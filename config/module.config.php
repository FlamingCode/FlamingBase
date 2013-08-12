<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBase;

return array(
	'flamingbase' => array(
		'env_info' => array(
			// When no explicit config exists we search the ENV array with theese keys
			'search_keys' => array(
				'APPLICATION_ENV',
				'ENV',
			),

			// Use this to explicitly set the environment
			//'env' => 'production',
		),

		'emailer' => array(
			'default_from' => 'noreply@domain.invalid'
		),
	),

	'view_helpers' => array(
		'invokables' => array(
			'bootstrapifyMenu' => 'FlamingBase\View\Helper\BootstrapifyMenu',
			'ellipsis' => 'FlamingBase\View\Helper\Ellipsis',
			'formElementErrors' => 'FlamingBase\Form\View\Helper\FormElementErrors',
			'formRow' => 'FlamingBase\Form\View\Helper\FormRow',
		)
	),
);