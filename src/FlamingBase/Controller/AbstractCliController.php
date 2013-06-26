<?php

/*
 * Copyright (c) 2013, Flaming Code
 * All rights reserved.
 */

namespace FlamingBase\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * AbstractCliController
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 */
abstract class AbstractCliController extends AbstractActionController
{
	const FILE_SUFFIX = '.lock';

	protected $pid;

	protected $lockdir = 'data/tmp';

	/**
	 * Check to see if a cronjob is already running
	 */
	private function isrunning()
	{
		$pids = explode(PHP_EOL, `ps -e | awk '{print $1}'`);
		if (in_array($this->pid, $pids))
			return true;

		return false;
	}

	/**
	 * Create a lock for this process
	 * @return int
	 */
	public function lock()
	{
		$lock_file = $this->getLockFile();

		if (file_exists($lock_file)) {
			// Is running?
			$this->pid = file_get_contents($lock_file);
			if ($this->isrunning()) {
				error_log("==".$this->pid."== Already in progress...");
				return false;
			} else
				error_log("==".$this->pid."== Previous job died abruptly...");
		}

		$this->pid = getmypid();
		$s = file_put_contents($lock_file, $this->pid);
		error_log("==".$this->pid."== Lock acquired, processing the job...");
		return $this->pid;
	}

	public function unlock()
	{
		$lock_file = $this->getLockFile();

		if(file_exists($lock_file))
			unlink($lock_file);

		error_log("==".$this->pid."== Releasing lock...");
		return true;
	}

	protected function getLockFile()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		$controller = $params->controller;
		$action = $params->action;

		$normalizedController = strtolower(stripslashes(str_replace(__NAMESPACE__, '', $controller)));

		$fileBaseName = implode('_', array(
			basename($request->getScriptName()),
			$normalizedController,
			$action
		));

		return $this->lockdir . DIRECTORY_SEPARATOR . $fileBaseName . self::FILE_SUFFIX;
	}
}