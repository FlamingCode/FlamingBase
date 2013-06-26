<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Stdlib;

/**
 * StringTool
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
class StringTool
{
	public static function randStr($length = 64, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
	{
		// Length of the character list
		$chars_length = (strlen($chars) - 1);

		// Let us start our string
		$string = $chars{mt_rand(0, $chars_length)};

		// Generate the random string
		for ($i = 1; $i < $length; $i = strlen($string)) {
			// Select a random character from our list
			$r = $chars{mt_rand(0, $chars_length)};

			// We do not want the same two chars next to eachother
			if ($r != $string{$i - 1})
				$string .=  $r;
		}

		// Return the string
		return $string;
	}

	public static function randUpperStr($length = 64, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')
	{
		return self::randStr($length, $chars);
	}
}