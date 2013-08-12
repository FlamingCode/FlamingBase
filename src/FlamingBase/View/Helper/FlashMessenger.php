<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger as FlashMessengerPlugin;

/**
 * FlashMessenger
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class FlashMessenger extends AbstractHelper
{
	protected $plugin;

	public function __construct(FlashMessengerPlugin $plugin = null)
	{
		if ($plugin)
			$this->setPlugin($plugin);
	}

	public function __invoke($namespace = null)
	{
		if (null !== $namespace) {
			$plugin = $this->getPlugin();
			$plugin->setNamespace($namespace);
			return $plugin->getMessages();
		}
		return $this->getPlugin();
	}

	public function getPlugin()
	{
		if (!$this->plugin)
			$this->plugin = new FlashMessengerPlugin;
		return $this->plugin;
	}

	public function setPlugin(FlashMessengerPlugin $plugin)
	{
		$this->plugin = $plugin;
		return $this;
	}
}