<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return $config_ar = array(  
  'homeUrl' =>array('site/index'),
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ihost',
	'theme'=>'web',
	'defaultController' => 'site',
	'timeZone'=>"Asia/Shanghai",
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',		
		'application.components.*',
		'ext.yiiext.behaviors.model.taggable.*',
		'application.extensions.*',
		'application.modules.admin.models.*',	
		'application.helpers.*',	
	),

	'modules'=>array(
        'admin',
        'cp',
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'xiaochuan',
        ),
    ),
    	
	'language'	=> 'zh_cn',
	// application components
	'components'=>array(
	  'authManager' => array(
	    'class' => 'CDbAuthManager',
	    'connectionID' => 'db'
	  ),	  
        
	  'image'=>array(
      'class'=>'application.extensions.image.CImageComponent',            
      'driver'=>'GD',
      ),
        
		'coreMessages'	=> array( 
			'basePath' => 'protected/messages' 
		 ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'    => array('site/ilogin'),
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			//'urlFormat'     =>'path',
			//'showScriptName'=>false,
			//'urlSuffix'     =>'.html',
			'rules'=>array(
			  'ilogin' => 'site/login',
			  'blog' => 'blog/index',
			  'api' => 'blog/api',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
    /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
     */
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=imagine',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

    // 
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
