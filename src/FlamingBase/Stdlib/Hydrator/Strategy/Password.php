<?php

/*
 * Copyright (c) 2013, Flaming Code
 */

namespace FlamingBase\Stdlib\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * Password
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/FlamingCode/my-repo for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Password implements StrategyInterface
{
	public function extract($value)
	{
		return $value;
	}
	
	public function hydrate($value)
	{
		if (empty($value)) {
			unset($value);
			return false;
		}
			
		return $value;
	}
}