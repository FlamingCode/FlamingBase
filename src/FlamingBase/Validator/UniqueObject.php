<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Validator;

use DoctrineModule\Validator\UniqueObject as DoctrineUniqueObject;

/**
 * UniqueObject
 *
 * NOTE: The reason for this class is related to https://github.com/doctrine/DoctrineModule/issues/179
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class UniqueObject extends DoctrineUniqueObject
{
	protected function resolveValue($value, $context)
	{
		if (is_array($context) && count($context)) {
			return array_intersect_key($context, array_flip($this->fields));
		}

		return $value;
	}

	public function isValid($value, $context = null)
	{
		// Doctrine doesn't like when the id key is missing from the context
		if (!array_key_exists('id', $context))
			$context['id'] = 0;
		$value = $this->resolveValue($value, $context);
		return parent::isValid($value, $context);
	}
}