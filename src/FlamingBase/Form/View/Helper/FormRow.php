<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Form\View\Helper;

use CoreBootstrap\Form\View\Helper\FormRow as BootstrapFormRow;

/**
 * FormRow
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
class FormRow extends BootstrapFormRow
{
	public function renderBootstrapOptions($elementString, $options)
	{
		$escapeHtmlHelper = $this->getEscapeHtmlHelper();

		if (isset($options['prepend']) || isset($options['append'])) {
			$template = $this->bootstrapTemplates['prependAppend'];
			$class = '';
			$prepend = '';
			$append = '';
			if (isset($options['prepend'])) {
				$class .= 'input-prepend ';
				if (!is_array($options['prepend'])) {
					$options['prepend'] = (array) $options['prepend'];
				}
				foreach ($options['prepend'] as $p) {
					if (is_array($p)) {
						$attrStr = '';
						foreach ($p as $attr => $attrVal)
							$attrStr .= ' ' . $attr . '="' . $attrVal . '"';

						$prepend .= '<span class="add-on">' . sprintf('<i%s></i>', $attrStr) . '</span>';
					} else
						$prepend .= '<span class="add-on">' . $escapeHtmlHelper($p) . '</span>';
				}
			}
			if (isset($options['append'])) {
				$class .= 'input-append ';
				if (!is_array($options['append'])) {
					$options['append'] = (array) $options['append'];
				}
				foreach ($options['append'] as $a) {
					if (is_array($a)) {
						$attrStr = '';
						foreach ($a as $attr => $attrVal)
							$attrStr .= ' ' . $attr . '="' . $attrVal . '"';

						$append .= '<span class="add-on">' . sprintf('<i%s></i>', $attrStr) . '</span>';
					} else
						$append .= '<span class="add-on">' . $escapeHtmlHelper($a) . '</span>';
				}
			}

			$elementString = sprintf($template, $class, $prepend, $elementString, $append);
		}
		if (isset($options['help'])) {
			$help = $options['help'];
			$template = $this->bootstrapTemplates['help'];
			$style = 'inline';
			$content = '';
			if (is_array($help)) {
				if (isset($help['style'])) {
					$style = $help['style'];
				}
				if (isset($help['content'])) {
					$content = $help['content'];
					if (null !== ($translator = $this->getTranslator())) {
						$content = $translator->translate(
							$content, $this->getTranslatorTextDomain()
						);
					}
				}
			} else {

				$content = $help;
			}

			$tag = $style == 'block' ? 'p' : 'span';

			$elementString .= sprintf(
				$template, $tag, $style, $content
			);
		}

		return $elementString;
	}
}