<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Stdlib\Hydrator\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * DoctrineObject
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class DoctrineObject extends AbstractCollectionStrategy
{
	public function extract($value)
	{
		if (is_numeric($value) || null === $value)
			return $value;

		return $value->getId();
	}

	public function hydrate($value)
	{
		return $value;
	}
}