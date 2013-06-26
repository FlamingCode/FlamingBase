<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Stdlib;

/**
 * ImageTool
 *
 * Uses GD2
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
class ImageTool
{
	const IMG_QUALITY = 100;
	const MIRROR_HORIZONTAL = 1;
	const MIRROR_VERTICAL = 2;
	const MIRROR_BOTH = 3;

	/**
	 * Converts image to jpeg and optionally saves it to a given path.
	 *
	 * @param String $inputImg
	 * @param String $savePath
	 * @param int $quality
	 * @param array $exifData
	 * @return Boolean|ImageResource
	 */
	public static function convert2Jpeg($inputImg, $savePath = null, $quality = null, array $exifData = null)
	{
		$retval = false;
		$img = self::imgCreate($inputImg);
		$imgSize = self::size($img);
		$jpegImg = imagecreatetruecolor($imgSize[0], $imgSize[1]);
		imagecopy($jpegImg, $img, 0, 0, 0, 0, $imgSize[0], $imgSize[1]);

		if (null === $quality)
			$quality = self::IMG_QUALITY;

		if (null !== $exifData && array_key_exists('Orientation', $exifData)) {
			$ort = $exifData['Orientation'];
			switch ($ort) {
				default:
				case 1: // nothing
					break;

				case 2: // horizontal flip
					$jpegImg = self::flipImage($jpegImg, 1);
					break;

				case 3: // 180 rotate left
					$jpegImg = self::rotateImage($jpegImg, 180);
					break;

				case 4: // vertical flip
					$jpegImg = self::flipImage($jpegImg, 2);
					break;

				case 5: // vertical flip + 90 rotate right
					$jpegImg = self::flipImage($jpegImg, 2);
					$jpegImg = self::rotateImage($jpegImg, 90);
					break;

				case 6: // 90 rotate right
					$jpegImg = self::rotateImage($jpegImg, 90);
					break;

				case 7: // horizontal flip + 90 rotate right
					$jpegImg = self::flipImage($jpegImg, 1);
					$jpegImg = self::rotateImage($jpegImg, 90);
					break;

				case 8:    // 90 rotate left
					$jpegImg = self::rotateImage($jpegImg, 270);
					break;
			}
		}

		if (null === $savePath)
			$retval = $jpegImg;
		else
			$retval = imagejpeg($jpegImg, $savePath, $quality);
		return $retval;
	}

	private static function imgCreate($imgStr)
	{
		if (is_string($imgStr)) {
			$tmp = explode('.', $imgStr);
			$ext = strtolower(end($tmp));

			$img = null;

			switch ($ext) {
				case 'png':
					$img = imagecreatefrompng($imgStr);
					break;
				case 'gif':
					$img = imagecreatefromgif($imgStr);
					break;
				case 'bmp':
					$img = imagecreatefromwbmp($imgStr);
					break;
				case 'jpg':
				case 'jpeg':
				default:
					$img = imagecreatefromjpeg($imgStr);
					break;
			}

			return $img;
		}
		return $imgStr;
	}

	private static function resize($origImg, $newSize, $mode = 'width')
	{
		if (is_string($origImg))
			$fullSize = self::imgCreate($origImg);
		else
			$fullSize = $origImg;

		$origWidth = imagesx($fullSize);
		$origHeight = imagesy($fullSize);

		switch ($mode) {
			case 'height':
				$newHeight = $newSize;
				$ratio = $origWidth / $origHeight;
				$newWidth = $ratio * $newHeight;
				break;
			case 'width':
			default:
				$newWidth = $newSize;
				$ratio = $origHeight / $origWidth;
				$newHeight = $ratio * $newWidth;
				break;
		}

		$resizedImg = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($resizedImg, $fullSize, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

		if (is_string($origImg))
			imagedestroy($fullSize);

		return $resizedImg;
	}

	public static function resizeByWidthKeepRatio($origImg, $newWidth)
	{
		return self::resize($origImg, $newWidth, 'width');
	}

	public static function resizeByLongSide($origImg, $newSize)
	{
		$mode = 'width';
		$size = self::size($origImg);

		if ($size[1] > $size[0])
			$mode = 'height';

		return self::resize($origImg, $newSize, $mode);
	}

	public static function resizeByShortSide($origImg, $newSize)
	{
		$mode = 'width';
		$size = self::size($origImg);

		if ($size[1] < $size[0])
			$mode = 'height';

		return self::resize($origImg, $newSize, $mode);
	}

	public static function resizeToThumb($origImg, $newSize)
	{
		$resizedImg = self::resizeByShortSide($origImg, $newSize);

		$resizedSize = self::size($resizedImg);

		$xOffset = ($resizedSize[0] / 2) - ($newSize / 2);
		$yOffset = ($resizedSize[1] / 2) - ($newSize / 2);

		$thumb = imagecreatetruecolor($newSize, $newSize);

		imagecopy($thumb, $resizedImg, 0, 0, $xOffset, $yOffset, $newSize, $newSize);

		return $thumb;
	}

	/**
	 * Calculates the image size - width and height in px.
	 *
	 * @param mixed $img
	 * @return array
	 */
	public static function size($inputImg)
	{
		if (is_string($inputImg))
			$img = self::imgCreate($inputImg);
		else
			$img = $inputImg;

		$imgW = imagesx($img);
		$imgH = imagesy($img);

		if (is_string($inputImg))
			imagedestroy($img);

		return array($imgW, $imgH);
	}

	public static function rotateImage($img, $rotation)
	{
		$width = imagesx($img);
		$height = imagesy($img);
		switch ($rotation) {
			case 0:
			case 360:
				return $img;
				break;
			case 90:
				$newimg = @imagecreatetruecolor($height, $width);
				break;
			case 180:
				$newimg = @imagecreatetruecolor($width, $height);
				break;
			case 270:
				$newimg = @imagecreatetruecolor($height, $width);
				break;
		}
		if ($newimg) {
			for ($i = 0; $i < $width; $i++) {
				for ($j = 0; $j < $height; $j++) {
					$reference = imagecolorat($img, $i, $j);
					switch ($rotation) {
						case 90:
							if (!@imagesetpixel($newimg, ($height - 1) - $j, $i, $reference))
								return false;
							break;
						case 180:
							if (!@imagesetpixel($newimg, $width - $i, ($height - 1) - $j, $reference))
								return false;
							break;
						case 270:
							if (!@imagesetpixel($newimg, $j, $width - $i, $reference))
								return false;
							break;
					}
				}
			}
			return $newimg;
		}
		return false;
	}

	public static function flipImage($src, $type)
	{
		$imgsrc = imagecreatefromjpeg($src);
		$width = imagesx($imgsrc);
		$height = imagesy($imgsrc);
		$imgdest = imagecreatetruecolor($width, $height);

		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
				if ($type == self::MIRROR_HORIZONTAL)
					imagecopy($imgdest, $imgsrc, $width - $x - 1, $y, $x, $y, 1, 1);
				if ($type == self::MIRROR_VERTICAL)
					imagecopy($imgdest, $imgsrc, $x, $height - $y - 1, $x, $y, 1, 1);
				if ($type == self::MIRROR_BOTH)
					imagecopy($imgdest, $imgsrc, $width - $x - 1, $height - $y - 1, $x, $y, 1, 1);
			}
		}

		return $imgdest;
	}

}