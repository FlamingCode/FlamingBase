<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Module
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
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
					$envConfig = $config['env_info'];

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
					$controllerPlugin->setDefaultFrom($config['emailer']['default_from']);
					return $controllerPlugin;
				},
			)
		);
	}

	public function onBootstrap(MvcEvent $e)
	{
		$e->getApplication()->getServiceManager()->get('translator');
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
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
}