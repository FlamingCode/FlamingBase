<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
//use Zend\Mail\Message;
//use Zend\Mail\Transport\Sendmail as MailTransport;
//use Zend\Mail\Transport\File as FileTransport;
//use Zend\Mail\Transport\FileOptions;

/**
 * Emailer
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link http://github.com/flamingcode/flamingbase for the canonical source repository
 * @license http://opensource.org/licenses/GPL-2.0 GPLv2
 */
class Emailer extends AbstractPlugin
{
	protected $defaultFrom;

	public function __construct($defaultFrom = null)
	{
		if ($defaultFrom)
			$this->setDefaultFrom($defaultFrom);
	}

	public function sendMail($to, $subject, $body, $from = null, array $additionalHeaders = array())
	{
		if (!$from)
			$from = $this->getDefaultFrom();

		$headers = array_merge($additionalHeaders, array('From' => $from));

		$headerStr = implode("\r\n", array_map(function($val, $key) { return $key . ': ' . $val; } , $headers, array_keys($headers)));

		mail($to, $subject, $body, $headerStr);

		// For some reason Zend\Mail\Transport\SendMail doesn't work...
//		$mail = new Message;
//		$mail->addTo($to)
//		     ->setFrom('noreply@tasti.dk', 'Tasti.dk')
//		     ->setSubject($subject)
//		     ->setBody($body);
//
//		if ('development' == $this->env()) {
//			$options = new FileOptions(array(
//				'path' => 'data/tmp',
//				'callback' => function($transport) use ($subject) {
//					return str_replace(' ', '_', $subject) . '.txt';
//				}
//			));
//			$transport = new FileTransport($options);
//		} else {
//			$transport = new MailTransport;
//		}
//		$transport->send($mail);
	}

	public function getDefaultFrom()
	{
		return $this->defaultFrom;
	}

	public function setDefaultFrom($from)
	{
		$this->defaultFrom = (string) $from;
		return $this;
	}
}