<?php
  return $sep_config_ar = array(  
 	  'theme'=>'web',	
    
    'components'=>array(
  		'urlManager'=>array(
			'urlFormat'     =>'path',
			'showScriptName'=>false,
			'urlSuffix'     =>'.html',
			'rules'=>array(
        '/'                   => 'site/index',
			  'ilogin'              => 'site/ilogin',
  //      'fashion'             => 'site/fashion',
 //       'makeup'              => 'site/makeup',
//        'site/makeup/<id:\d+>'     => 'site/makeup',

        'site/about/<id:\d+>' => 'site/about',
        'site/about/<id:\w+>' => 'site/about',

        'site/news/<id:\d+>'  => 'site/news',
        'site/news/<id:\w+>'  => 'site/news',

				//'topic/create/<id:\d+>' =>'t/create',
				'<controller:\w+>/<id:\d+>'=>'<controller>/index',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			  ),
		  ),
    )

  );
?>
