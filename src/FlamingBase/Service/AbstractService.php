<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Service;

use Doctrine\ORM\EntityManager;

use ArrayObject;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * AbstractService
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
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

	public function getHydrator()
	{
		return $this->hydrator;
	}

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