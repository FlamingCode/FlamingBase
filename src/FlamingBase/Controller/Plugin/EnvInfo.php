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
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class EnvInfo extends AbstractPlugin
{
	const ENV_DEVELOPMENT = 'development';
	const ENV_TESTING = 'testing';
	const ENV_STAGING = 'staging';
	const ENV_PRODUCTION = 'production';

	protected $env;

	protected $searchKeys = array(
		'APPLICATION_ENV',
		'ENV',
	);

	public function __invoke()
	{
		return $this->getEnv();
	}

	public function setEnv($env)
	{
		$this->env = (string) $env;
		return $this;
	}

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

	public function getSearchKeys()
	{
		return $this->searchKeys;
	}

	public function setSearchKeys(array $searchKeys)
	{
		$this->searchKeys = $searchKeys;
		return $this;
	}
}