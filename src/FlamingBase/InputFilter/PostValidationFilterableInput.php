<?php

/*
 * Copyright (c) 2013, Flaming Code
 */

namespace FlamingBase\InputFilter;

use Zend\InputFilter\InputInterface;
use Zend\InputFilter\Input;
use Zend\Filter\FilterChain;

/**
 * PostValidationFilterableInput
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/my-repo for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class PostValidationFilterableInput extends Input
{
	/**
	 *
	 * @var FilterChain
	 */
	protected $postValidationFilterChain;
	
	/**
	 * 
	 * @return FilterChain
	 */
	public function getPostValidationFilterChain()
	{
		return $this->postValidationFilterChain;
	}
	
	/**
	 * 
	 * @param FilterChain $filterChain
	 * @return PostValidationFilterableInput
	 */
	public function setPostValidationFilterChain(FilterChain $filterChain)
	{
		$this->postValidationFilterChain = $filterChain;
		return $this;
	}
	
	/**
	 * 
	 * @param mixed $context
	 * @return bool
	 */
	public function isValid($context = null)
	{
		$result = parent::isValid($context);
		$value = $this->getValue();
		if ($result) {
			$filterChain = $this->getPostValidationFilterChain();
			$value = $filterChain->filter($value);
			$this->setValue($value);
		}
		
		return $result;
	}
	
	public function merge(InputInterface $input)
	{
		parent::merge($input);
		if ($input instanceof PostValidationFilterableInput)
			$this->getPostValidationFilterChain()->merge($input->getPostValidationFilterChain());
		return $this;
	}
}