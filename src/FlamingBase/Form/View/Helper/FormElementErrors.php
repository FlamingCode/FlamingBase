<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as ZendFormElementErrors;
use Zend\Form\ElementInterface;

/**
 * FormElementErrors
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
class FormElementErrors extends ZendFormElementErrors
{
	public function render(ElementInterface $element, array $attributes = array())
	{
		if (!array_key_exists('class', $attributes))
			$attributes['class'] = '';
		$attributes['class'] .= ' error';
		return parent::render($element, $attributes);
	}
}