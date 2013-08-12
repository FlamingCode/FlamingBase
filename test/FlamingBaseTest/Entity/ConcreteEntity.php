<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBaseTest\Entity;

use ArrayObject;
use DateTime;

use FlamingBase\Entity\AbstractEntity;

/**
 * ConcreteEntity
 *
 * Just a simple implementation of the AbstractEntity.
 * We need this in order to instanciate an object.
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class ConcreteEntity extends AbstractEntity
{
	/**
	 *
	 * @var int
	 */
	protected $id;

	/**
	 *
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @var ArrayObject string[]
	 */
	protected $skills;

	/**
	 *
	 * @var DateTime
	 */
	protected $timestamp;

	/**
	 *
	 * @param array $options
	 */
	public function __construct(array $options = null)
	{
		$this->skills = new ArrayObject;
		parent::__construct($options);
	}

	/**
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 *
	 * @param int $id
	 * @return ConcreteEntity
	 */
	public function setId($id)
	{
		$this->id = (int) $id;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $name
	 * @return ConcreteEntity
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
		return $this;
	}

	/**
	 *
	 * @return array string[]
	 */
	public function getSkills()
	{
		return $this->skills->getArrayCopy();
	}

	/**
	 *
	 * @param ArrayObject|array $skills
	 * @return ConcreteEntity
	 */
	public function setSkills($skills)
	{
		if ($skills instanceof ArrayObject)
			$this->skills = $skills;
		else if (is_array($skills))
			$this->skills->exchangeArray($skills);
		$this->skills->natcasesort();
		return $this;
	}

	/**
	 *
	 * @return DateTime
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 *
	 * @param DateTime|string $datetime
	 * @return ConcreteEntity
	 */
	public function setTimestamp($datetime)
	{
		if ($datetime instanceof DateTime)
                        $this->timestamp = $datetime;
                else if (is_string($datetime))
                        $this->timestamp = new DateTime($datetime);
		return $this;
	}
}