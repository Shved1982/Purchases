<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Test Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.modules.*',
		'application.components.*',
		'application.extensions.*',
	),

	'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'123456',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1'),
			),
	),

	// application components
	'components'=>array(
		'authManager'=>array(
		   'class'=>'CDbAuthManager',
		   'connectionID'=>'db',
		   'defaultRoles' => array('guest')
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => FALSE,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=test_loc',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array(
					'header' => '',
					'nextPageLabel'=>'Следующая <i class="fa fa-long-arrow-right"></i>',
					'prevPageLabel'=>'<i class="fa fa-long-arrow-left"></i> Предыдущая',
					'lastPageLabel'=>'Последняя',
					'firstPageLabel'=>'Первая',
					'selectedPageCssClass' => 'active',
					'hiddenPageCssClass' => 'disabled',
					'htmlOptions' => array(
						'class' => 'pagination',
					 ),
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'',
		'host' => '',
		'username' => '',
		'password' => '',
		'port' => '',
		'encryption'=>'',
		'smtpauth' => true,
	),
);