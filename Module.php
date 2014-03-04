<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Module
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class Module
{
	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'flashMessenger' => function ($helpers) {
					$sm = $helpers->getServiceLocator();
					$plugin = $sm->get('ControllerPluginManager')->get('flashmessenger');
					return new View\Helper\FlashMessenger($plugin);
				},
			)
		);
	}

	public function getControllerPluginConfig()
	{
		return array(
			'factories' => array(
				'env' => function($helpers) {
					$serviceLocator = $helpers->getServiceLocator();
					$config = $serviceLocator->get('Configuration');
					$envConfig = $config['flamingbase']['env_info'];

					$controllerPlugin = new Controller\Plugin\EnvInfo;
					if (array_key_exists('env', $envConfig))
						$controllerPlugin->setEnv($envConfig['env']);
					else
						$controllerPlugin->setSearchKeys($envConfig['search_keys']);
					return $controllerPlugin;
				},

				'emailer' => function($helpers) {
					$serviceLocator = $helpers->getServiceLocator();
					$config = $serviceLocator->get('Configuration');

					$controllerPlugin = new Controller\Plugin\Emailer();
					$controllerPlugin->setDefaultFrom($config['flamingbase']['emailer']['default_from']);
					return $controllerPlugin;
				},
			)
		);
	}

	public function onBootstrap(MvcEvent $e)
	{
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
}
