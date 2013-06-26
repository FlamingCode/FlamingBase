<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Stdlib\Hydrator\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 * DoctrineObject
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
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