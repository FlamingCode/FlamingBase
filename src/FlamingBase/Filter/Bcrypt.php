<?php

/*
 * Copyright (c) 2013, Flaming Code
 */

namespace FlamingBase\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Crypt\Password\Bcrypt as BcryptPassword;

/**
 * Bcrypt
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/my-repo for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class Bcrypt extends AbstractFilter
{
	const DEFAULT_PASS_COST = 14;
	
	/**
	 *
	 * @var int
	 */
	protected $cost = self::DEFAULT_PASS_COST;
	
	public function getCost()
	{
		return $this->cost;
	}
	
	public function setCost($cost)
	{
		$this->cost = (int) $cost;
		return $this;
	}
	
	public function filter($value)
	{
		$bcrypt = new BcryptPassword;
		$bcrypt->setCost($this->getCost());
		return $bcrypt->create($value);
	}
}