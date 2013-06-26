<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Ellipsis
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
class Ellipsis extends AbstractHelper
{
	public function __invoke($str, $max = 45, $rep = '...')
	{
		return $this->ellipsisString($str, $max, $rep);
	}

	public function ellipsisString($str, $max = 45, $rep = '...')
	{
		if(mb_strlen($str, 'utf-8') <= $max)
			return $str;

		// find the longest possible match
		$pos = 0;
		foreach(array('. ', '? ', '! ') as $punct) {
			$pPos = mb_strpos($str, $punct, $pos, 'utf-8');
			while($pPos > $pos && $pPos < $max) {
				$pos = $pPos;
				$pPos = mb_strpos($str, $punct, $pos + 1, 'utf-8');
			}
		}

		if(!$pos) {
			// substr $len-3, because the ellipsis adds 3 chars
			return mb_substr($str, 0, $max - mb_strlen($rep, 'utf-8'), 'utf-8') . $rep;
		}

		// $pos+1 to grab punctuation mark
		return mb_substr($str, 0, $pos + 1, 'utf-8');
	}
}