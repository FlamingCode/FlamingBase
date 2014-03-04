<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Form\Element;

use Zend\Form\Element\DateTime as ZendDateTime;

use DateTime;

/**
 * DateTime
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class DateTimePicker extends ZendDateTime
{
	/**
	 * Seed attributes
	 *
	 * @var array
	 */
	protected $attributes = array(
		'type' => 'text',
		'class' => 'datetimepicker'
	);

	/**
	 * Provide default input rules for this element
	 *
	 * Attaches default validators for the datetime input.
	 *
	 * @return array
	 */
	public function getInputSpecification()
	{
		$datetimeElement = $this;

		return array(
			'name' => $this->getName(),
			'required' => true,
			'filters' => array(
				array('name' => 'Zend\Filter\StringTrim'),
				array(
					'name' => 'Callback',
					'options' => array(
						'callback' => function ($value) use ($datetimeElement) {
							if (!empty($value) && is_string($value)) {
								return DateTime::createFromFormat($datetimeElement->getFormat(), $value);
							}
							return $value;
						}
					)
				)
			),
			'validators' => $this->getValidators(),
		);
	}
}