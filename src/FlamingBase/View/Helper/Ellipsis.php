<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Ellipsis
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class Ellipsis extends AbstractHelper
{
	const DEFAULT_REP = '...';
	const DEFAULT_MAX = 45;
	
	/**
	 * 
	 * @param string $str
	 * @param int $max
	 * @param string $rep
	 * @return string
	 */
	public function __invoke($str, $max = self::DEFAULT_MAX, $rep = self::DEFAULT_REP)
	{
		return $this->ellipsisString($str, $max, $rep);
	}

	/**
	 * 
	 * @param string $str
	 * @param int $max
	 * @param string $rep
	 * @return string
	 */
	public function ellipsisString($str, $max = self::DEFAULT_MAX, $rep = self::DEFAULT_REP)
	{
		if(mb_strlen($str, 'utf-8') <= $max)
			return $str;

		// Find the longest possible match
		$pos = 0;
		foreach(array('. ', '? ', '! ') as $punct) {
			$pPos = mb_strpos($str, $punct, $pos, 'utf-8');
			while($pPos > $pos && $pPos < $max) {
				$pos = $pPos;
				$pPos = mb_strpos($str, $punct, $pos + 1, 'utf-8');
			}
		}

		if(!$pos)
			return mb_substr($str, 0, $max - mb_strlen($rep, 'utf-8'), 'utf-8') . $rep;

		// $pos + 1 to grab punctuation mark
		return mb_substr($str, 0, $pos + 1, 'utf-8');
	}
}