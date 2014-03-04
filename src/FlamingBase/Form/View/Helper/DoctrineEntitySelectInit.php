<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;

/**
 * DoctrineEntitySelectInit
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class DoctrineEntitySelectInit extends AbstractHelper
{
	public function __invoke(ElementInterface $element = null)
	{
		if (!$element) {
			return $this;
		}

		if ($element instanceof ObjectSelect ||
		    $element instanceof ObjectMultiCheckbox) {
			$type = $element->getAttribute('type');
			$valueOptions = $element->getOption('value_options');

			if (('select' == $type || 'multi_checkbox' == $type) &&
			    !is_array($valueOptions)) {
				$valueOptions = $element->getValueOptions();
				foreach ($valueOptions as $key => $value) {
					$valueOptions[$key]['label_attributes'] = array('class' => '');
				}
				$element->setOptions(array('value_options' => $valueOptions));
			}
		}

		return $element;
	}
}