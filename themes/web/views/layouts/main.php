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
	$cs->registerCssFile($theme_baseurl.'/css/all.css');	
	$cs->registerCssFile($theme_baseurl.'/css/jquery.jscrollpane.css');	
	$cs->registerCssFile($theme_baseurl.'/css/jquery.jscrollpane.lozenge.css');	
	$cs->registerCssFile($theme_baseurl.'/js/fancybox/jquery.fancybox-1.3.4.css');	
?>
 
  <title><?php 
  if( !empty($this->_pageTitle) ) {
    echo $this->_pageTitle;
  }
  echo SITE_TITLE;
  ?></title>
</head>
<body>
  <div id="header">
    <div class="container">
      <div class='grid3 first logo'>
        <h1 title="影像志">
          <a href="/"><img src="<?php echo $theme_baseurl?>/img/logo.png" alt='' /></a>
        </h1>
      </div>
      <div class='grid9 nav'>                
        <a href="/index.php" title="" class='home'>首页</a>
        <a href="<?php echo url('site/fashion'); ?>" title=""
          class='fashion <?php echo API::isaction('site/fashion') ?>'>时尚</a>
        <a href="<?php echo url('site/makeup') ?>" title=""
          class="markup <?php echo API::isaction('site/makeup') ?> ">美容</a>
        <a href="<?php echo url('site/celebrities') ?>" title=""
          class="famous <?php echo API::isaction('site/celebrities') ?>">名人</a>
        <a href="<?php echo url('site/advertising') ?>" title=""
          class="adv <?php echo API::isaction('site/advertising') ?> ">广告</a>
        <a href="<?php echo url('site/fcreate') ?>" title=""
          class="feedback <?php echo API::isaction( array( 'site/fcreate','site/feedback') ) ?> ">留言</a>
        <a href="<?php echo url('site/about') ?>" title=""
          class="aboutus <?php echo API::isaction('site/about') ?>  ">关于我们</a>
      </div>
    </div>
  </div><!-- header end -->
  
 <?php echo $content; ?>  

  <div id="footer">
    <div class="container clearfix">  
      <div class="grid6 first copyright">
        <p>版权所有 © 福州影像志有限公司(虚构)  ICP备888888号</p>
      </div>  
      <div class='grid6 about_link'>
      <?php
        $iabout     =& API::node(array('ident_label' => 'ipage'));
        $articles   =& $iabout->articles( array( 'order' => 'sort_id asc ') );
        foreach( $articles as $inst ) {
      ?>
        <a href="<?php echo url('site/about',array('id'=>$inst->urlarg) ) ?>"><?php echo $inst->title; ?></a>
      <?php
        }
      ?>
      </div>
    </div>
  </div><!-- footer end -->

  <?php
  //	Yii::app()->clientScript->registerCoreScript('jquery');  
  ?>
</body>
</html>
 <script type="text/javascript" src="<?php echo $baseUrl; ?>/js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/jquery.mousewheel.js"></script>	
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/jquery.jscrollpane.min.js"></script> 
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/jquery.lazyload.js"></script>
  <script type="text/javascript" src="<?php echo $theme_baseurl?>/js/script.js"></script>
  