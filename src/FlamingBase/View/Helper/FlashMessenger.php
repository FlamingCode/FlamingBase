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
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class FlashMessenger extends AbstractHelper
{
	/**
	 *
	 * @var FlashMessengerPlugin
	 */
	protected $plugin;

	/**
	 * 
	 * @param FlashMessengerPlugin $plugin
	 */
	public function __construct(FlashMessengerPlugin $plugin = null)
	{
		if ($plugin)
			$this->setPlugin($plugin);
	}

	/**
	 * 
	 * @param sting|null $namespace
	 * @return FlashMessengerPlugin
	 */
	public function __invoke($namespace = null)
	{
		if (null !== $namespace) {
			$plugin = $this->getPlugin();
			$plugin->setNamespace($namespace);
			return $plugin->getMessages();
		}
		return $this->getPlugin();
	}

	/**
	 * 
	 * @return FlashMessengerPlugin
	 */
	public function getPlugin()
	{
		if (!$this->plugin)
			$this->plugin = new FlashMessengerPlugin;
		return $this->plugin;
	}

	/**
	 * 
	 * @param FlashMessengerPlugin $plugin
	 * @return FlashMessenger
	 */
	public function setPlugin(FlashMessengerPlugin $plugin)
	{
		$this->plugin = $plugin;
		return $this;
	}
}