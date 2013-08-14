<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Service;

use Doctrine\ORM\EntityManager;

use ArrayObject;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * AbstractService
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
abstract class AbstractService
{
	/**
	 *
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 *
	 * @var ArrayObject
	 */
	protected $options;

	/**
	 *
	 * @var HydratorInterface
	 */
	protected $hydrator;

	public function __construct(EntityManager $em = null, HydratorInterface $hydrator = null)
	{
		if ($em)
			$this->setEntityManager($em);
		if ($hydrator)
			$this->setHydrator($hydrator);
	}

	/**
	 *
	 * @return EntityManager
	 */
	public function getEntityManager()
	{
		return $this->entityManager;
	}

	/**
	 *
	 * @param EntityManager $entityManager
	 * @return AbstractService
	 */
	public function setEntityManager(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
		return $this;
	}

	/**
	 * 
	 * @return HydratorInterface
	 */
	public function getHydrator()
	{
		if (!$this->hydrator)
			$this->hydrator = new ClassMethods(false);
		return $this->hydrator;
	}

	/**
	 * 
	 * @param HydratorInterface $hydrator
	 * @return AbstractService
	 */
	public function setHydrator(HydratorInterface $hydrator)
	{
		$this->hydrator = $hydrator;
		return $this;
	}

	/**
	 *
	 * @return ArrayObject
	 */
	public function getOptions()
	{
		if (!$this->options)
			$this->options = new ArrayObject;
		return $this->options;
	}

	/**
	 * 
	 * @param mixed $option
	 * @return mixed
	 */
	public function getOption($option)
	{
		if ($this->options->offsetExists($option))
			return $this->options->offsetGet($option);
		return null;
	}

	/**
	 *
	 * @param ArrayObject $options
	 * @return AbstractService
	 */
	public function setOptions($options)
	{
		if (is_array($options))
			$this->options = new ArrayObject($options);
		else if ($options instanceof ArrayObject)
			$this->options = $options;
		return $this;
	}
}