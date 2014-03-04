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
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class UniqueObject extends DoctrineUniqueObject
{
	/**
	 * 
	 * @param mixed $value
	 * @param mixed $context
	 * @return mixed
	 */
	protected function resolveValue($value, $context)
	{
		if (is_array($context) && count($context))
			return array_intersect_key($context, array_flip($this->fields));
		return $value;
	}

	/**
	 * 
	 * @param mixed $value
	 * @param int $context
	 * @return bool
	 */
	public function isValid($value, $context = null)
	{
		// Doctrine doesn't like when the id key is missing from the context
		if (!array_key_exists('id', $context))
			$context['id'] = 0;
		$value = $this->resolveValue($value, $context);
		return parent::isValid($value, $context);
	}
}