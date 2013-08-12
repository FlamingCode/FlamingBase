<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\View\Helper;

use DOMDocument;
use DOMXPath;
use Zend\View\Helper\AbstractHelper;

/**
 * BootstrapifyMenu
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class BootstrapifyMenu extends AbstractHelper
{
	public function __invoke($html = null)
	{
		if (null === $html)
			return $this;

		if (empty($html))
			return '';

		return $this->applyBootstrapClassesAndIds($html);
	}

	/**
	 * Applies the custom Twitter Bootstrap dropdown class/id attributes where
	 * necessary.
	 *
	 * @param  string $html The HTML
	 * @return string
	 */
	protected function applyBootstrapClassesAndIds($html)
	{
		$domDoc = new DOMDocument('1.0', 'utf-8');
		$domDoc->loadXML('<?xml version="1.0" encoding="utf-8"?>' . $html);

		$xpath = new DOMXPath($domDoc);

		foreach ($xpath->query('//a[starts-with(@href, "#")]') as $item) {
			$result = $xpath->query('../ul', $item);

			if ($result->length === 1) {
				$ul = $result->item(0);
				$ul->setAttribute('class', 'dropdown-menu');

				$li = $item->parentNode;
				$li->setAttribute('id', substr($item->getAttribute('href'), 1));

				if (($existingClass = $li->getAttribute('class')) !== '') {
					$li->setAttribute('class', $existingClass . ' dropdown');
				} else {
					$li->setAttribute('class', 'dropdown');
				}

				$item->setAttribute('data-toggle', 'dropdown');

				if (($existingClass = $item->getAttribute('class')) !== '') {
					$item->setAttribute('class', $item->getAttribute('class') . ' dropdown-toggle');
				} else {
					$item->setAttribute('class', 'dropdown-toggle');
				}

				$space = $domDoc->createTextNode(' ');

				$item->appendChild($space);

				$caret = $domDoc->createElement('b', '&nbsp;');
				$caret->setAttribute('class', 'caret');

				$item->appendChild($caret);
			}
		}

		return $domDoc->saveXML($xpath->query('/ul')->item(0));
	}
}