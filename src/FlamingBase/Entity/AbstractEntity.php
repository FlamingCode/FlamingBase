<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Entity;

use Exception;

/**
 * AbstractEntity
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
abstract class AbstractEntity
{
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
	 * @throws Exception
	 */
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (!method_exists($this, $method))
			throw new Exception('Invalid property: ' . $name);
		$this->$method($value);
	}

	/**
	 *
	 * @param string $name
	 * @return mixed
	 * @throws Exception
	 */
	public function __get($name)
	{
		$method = 'get' . $name;
		if (!method_exists($this, $method))
			throw new Exception('Invalid property: ' . $name);
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
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods))
				$this->$method($value);
		}
		return $this;
	}
}