<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" /> 
<?php  
  $theme_baseurl = API::get_theme_baseurl();  
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();	
//  $cs->registerCoreScript('jquery');  	
  $cs->registerCssFile($theme_baseurl.'/js/fancybox/jquery.fancybox-1.3.4.css');	
?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script type="text/javascript" src="<?php echo $theme_baseurl?>/swfupload/swfupload.js"></script>	
<script type="text/javascript" src="<?php echo $theme_baseurl?>/swfupload/swfupload.queue.js"></script> 
<script type="text/javascript" src="<?php echo $theme_baseurl?>/swfupload/fileprogress.js"></script> 
<script type="text/javascript" src="<?php echo $theme_baseurl?>/swfupload/handlers.js"></script> 
<link  rel="stylesheet"  type="text/css"  href="<?php echo $theme_baseurl?>/swfupload/swfupload.css" /> 
</head>
<body>
  <?php echo $this->renderPartial( '//layouts/flash') ?>
  <div id="w_top">
		<?php 
      $_isAdmin =& $this->iuser->account_type;
      $_isAdmin = $_isAdmin != 1 ? false : true;
      $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
			  array('label'=>Yii::t('cp','Website'), 'url'=>'/index.php', 'linkOptions' => array('target' => '_blank') ),

			  array('label'=>Yii::t('cp', 'Login'), 'url'=>array('/site/ilogin'),
          'visible'=>Yii::app()->user->isGuest,
          'itemOptions' => array('class' => API::isaction( array('/site/ilogin','ilogin.html')) )
          ),

			  array('label'=>Yii::t('cp','Logout').' ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),

				array('label'=>Yii::t('cp','Dashboard'), 'url'=>array('/cp/Dashboard/index'),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction('cp/Dashboard') ),
          ),

        array('label'=>'关于我们', 'url'=>array('/cp/article/ipage/208' ),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction( array(
                'cp/article/ipage/','/action/ipage/','/action/ipage.html' ) ) ),
          'linkOptions' => array( 'data' => 'nav_panel_Articles' )),


        array('label'=>'幻灯片', 'url'=>array('/cp/article/slideshow/276' ),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction( array(
                'cp/article/slideshow/','/action/slideshow/','/action/slideshow.html' ) ) ),
          'linkOptions' => array( 'data' => 'nav_panel_Articles' )),

        array('label'=>'作品墙', 'url'=>array('/cp/article/innode/206') ,
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction( array( 
                'cp/article/innode' ,'/action/innode/', '/action/innode.html') ) ) ,
          'linkOptions' => array( 'data' => 'nav_panel_Articles' )),

        array('label'=>'新闻', 'url'=>array('/cp/article/news/235') ,
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction( array( 
                'cp/article/news' ,'/action/news/', '/action/news.html') ) ) ,
          'linkOptions' => array( 'data' => 'nav_panel_Articles' )),


				array('label'=>Yii::t('cp','Attachment'), 'url'=>array('/cp/attachment/index/category_id/30'),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction('cp/attachment/') ),
          'linkOptions' => array( 'data' => 'panel_iattachment' )),

				array('label'=>Yii::t('cp','Users'), 'url'=>array('/cp/user/index'),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction('cp/user') ),
          'linkOptions' => array( 'data' => 'nav_panel_admins' )),

				array('label'=>Yii::t('cp','Feedback'), 'url'=>array('/cp/feedback/index'),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction('cp/feedback') ),
          'linkOptions' => array( 'data' => 'nav_panel_feedback' )),

				array('label'=>Yii::t('cp','Settings'), 'url'=>array('/cp/setting/index'),
          'visible' => $_isAdmin,
          'itemOptions' => array('class' => API::isaction('cp/setting') ),
          'linkOptions' => array( 'data' => 'nav_panel_settings' )),				
			),
		)); ?>
		
	</div><!-- top wrap end -->

	<?php echo $content; ?>  

<?php
//	Yii::app()->clientScript->registerCoreScript('jquery');  
	$cs->registerCssFile($theme_baseurl.'/css/all.css');	
?>
<!--[if lt IE 7]>
<link href="<?php echo $theme_baseurl?>/css/ie6.css" rel="stylesheet" type="text/css">
<![endif]-->
<script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl?>/js/tiny_mce/jquery.tinymce.js"></script> 
<script type="text/javascript" src="<?php echo $baseUrl?>/js/jquery.imasker.js"></script>
<script type="text/javascript" src="<?php echo $theme_baseurl?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $theme_baseurl?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $theme_baseurl; ?>/js/script.js"></script>
</body>
</html>
