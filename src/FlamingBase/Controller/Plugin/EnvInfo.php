<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * EnvInfo
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class EnvInfo extends AbstractPlugin
{
	const ENV_DEVELOPMENT = 'development';
	const ENV_TESTING = 'testing';
	const ENV_STAGING = 'staging';
	const ENV_PRODUCTION = 'production';

	/**
	 *
	 * @var string
	 */
	protected $env;

	/**
	 *
	 * @var array
	 */
	protected $searchKeys = array(
		'APPLICATION_ENV',
		'ENV',
	);

	/**
	 * 
	 * @return string
	 */
	public function __invoke()
	{
		return $this->getEnv();
	}

	/**
	 * 
	 * @param string $env
	 * @return EnvInfo
	 */
	public function setEnv($env)
	{
		$this->env = (string) $env;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getEnv()
	{
		if (!$this->env) {
			foreach ($this->getSearchKeys() as $envKey) {
				if ($env = getenv($envKey)) {
					$this->setEnv($env);
					break;
				}
			}
			// We couldn't find enything, default to production
			if (!$this->env)
				$this->setEnv(self::ENV_PRODUCTION);
		}
		return $this->env;
	}

	/**
	 * 
	 * @return array
	 */
	public function getSearchKeys()
	{
		return $this->searchKeys;
	}

	/**
	 * 
	 * @param array $searchKeys
	 * @return EnvInfo
	 */
	public function setSearchKeys(array $searchKeys)
	{
		$this->searchKeys = $searchKeys;
		return $this;
	}
}