<?php
  return $sep_config_ar = array(  
	  'theme'=>'compatible',

    'components'=>array(
  		'urlManager'=>array(
        'urlFormat' => 'path',
        'showScriptName'=>false,
			  'urlSuffix'     =>'.html',
        'rules'=>array(
			  'ilogin' => 'site/login',
			  'blog' => 'blog/index',
			  'api' => 'blog/api',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			  ),

      ),
     ),

  );
