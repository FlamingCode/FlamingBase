<?php

/*
 * Copyright (c) 2013, Flaming Code
 */

namespace FlamingBase\InputFilter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\Filter\FilterChain;
use Zend\InputFilter\InputFilterPluginManager;

/**
 * Factory
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/my-repo for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class Factory extends InputFactory
{
	/**
	 *
	 * @var FilterChain
	 */
	protected $defaultPostValidationFilterChain;
	
	/**
	 * 
	 * @param InputFilterPluginManager $inputFilterManager
	 */
	public function __construct(InputFilterPluginManager $inputFilterManager = null)
	{
		parent::__construct($inputFilterManager);
		$this->defaultPostValidationFilterChain = new FilterChain;
	}
	
	/**
	 * 
	 * @return FilterChain
	 */
	public function getDefaultPostValidationFilterChain()
	{
		return $this->defaultPostValidationFilterChain;
	}
	
	/**
	 * 
	 * @param FilterChain $filterChain
	 * @return Factory
	 */
	public function setDefaultPostValidateFilterChain(FilterChain $filterChain)
	{
		$this->defaultPostValidationFilterChain = $filterChain;
		return $this;
	}
	
	public function createInput($inputSpecification)
	{
		$input = parent::createInput($inputSpecification);
		if ($input instanceof PostValidationFilterableInput) {
			$input->setPostValidationFilterChain(clone $this->defaultPostValidationFilterChain);
			foreach ($inputSpecification as $key => $value) {
				switch ($key) {
					case 'post_validation_filters':
						if ($value instanceof FilterChain) {
							$input->setPostValidationFilterChain($value);
							break;
						}
						if (!is_array($value) && !$value instanceof Traversable) {
							throw new Exception\RuntimeException(sprintf(
								'%s expects the value associated with "post_validation_filters" to be an array/Traversable of filters or filter specifications, or a FilterChain; received "%s"'
								, __METHOD__, (is_object($value) ? get_class($value) : gettype($value))
							));
						}
						$this->populateFilters($input->getPostValidationFilterChain(), $value);
						break;
				}
			}
		}
		return $input;
	}
}