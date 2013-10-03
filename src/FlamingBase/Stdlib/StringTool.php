<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Stdlib;

use Zend\Math\Rand;

/**
 * StringTool
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class StringTool
{
	const ALL_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
	const ALL_UPPER_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	const ALL_LOWER_CHARS = 'abcdefghijklmnopqrstuvwxyz1234567890';
	
	public static function randStr($length = 64, $chars = self::ALL_CHARS)
	{
		return Rand::getString($length, $chars, true);
	}

	public static function randUpperStr($length = 64, $chars = self::ALL_UPPER_CHARS)
	{
		return self::randStr($length, $chars);
	}
	
	public static function randLowerStr($length = 64, $chars = self::ALL_LOWER_CHARS)
	{
		return self::randStr($length, $chars);
	}
}