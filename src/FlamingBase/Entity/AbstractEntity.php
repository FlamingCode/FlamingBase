<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Entity;

/**
 * AbstractEntity
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
abstract class AbstractEntity
{
	const GET_METHOD_PREFIX = 'get';
	const SET_METHOD_PREFIX = 'set';
	
	/**
	 * Constructor
	 *
	 * @param array $options An array of options to set
	 */
	public function __construct(array $options = null)
	{
		if (is_array($options))
			$this->setOptions($options);
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $value
	 * @throws Exception\UnknownPropertyException
	 */
	public function __set($name, $value)
	{
		$method = self::SET_METHOD_PREFIX . $name;
		if (!method_exists($this, $method))
			throw new Exception\UnknownPropertyException('Trying to set unknown property: ' . $name);
		$this->$method($value);
	}

	/**
	 *
	 * @param string $name
	 * @return mixed
	 * @throws Exception\UnknownPropertyException
	 */
	public function __get($name)
	{
		$method = self::GET_METHOD_PREFIX . $name;
		if (!method_exists($this, $method))
			throw new Exception\UnknownPropertyException('Trying to get unknown property: ' . $name);
		return $this->$method();
	}

	/**
	 *
	 * @param array $options
	 * @return AbstractEntity
	 */
	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = self::SET_METHOD_PREFIX . ucfirst($key);
			if (in_array($method, $methods))
				$this->$method($value);
		}
		return $this;
	}
}