<?php
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
 
/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}
 
/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

function setState($name,$value) {
  Yii::app()->user->setState($name, $value);
}
function getState($name) {
  $r =  Yii::app()->user->getState($name);
  Yii::app()->user->setState($name, $r);
  return str_replace('.html','',$r);
}
function getBackUrl() {
  return Yii::app()->request->cookies['back_url']->value;
}
/**
 * This is the shortcut to Yii::app()->user.
 */
function user() 
{
    return Yii::app()->getUser();
}

function controller() {
  return Yii::app()->controller->Id;
}

function action($a='') {
  if( strlen($a) > 0 ) {
    return $a;
  }
  return Yii::app()->controller->action->ID;
}
/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{ 
  //return Yii::app()->createUrl($route,$params,$ampersand);
  return Yii::app()->urlManager->createUrl($route, $params, $ampersand);
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}
 
/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) 
{
    return Yii::app()->params[$name];
}

function dump($target)
{
  return CVarDumper::dump($target, 10, true) ;
}

$colorful = "#093 #639 #693 #606 #669 #066 #033 #339 #999 #4588CE #9C0909 #171717 #CA0B0B #5FB509 #363636 #FF5900";
$colorful_array = explode(' ',$colorful);

function colorful($s='i l u'){
	global $colorful_array;	
	$color =  $colorful_array[rand(0,count($colorful_array)-1)];	
	return "<span style='color: $color' >".$s."</span>";
}

function colorfulV($s='i l u'){
	global $colorful_array;	
	return $colorful_array[rand(0,count($colorful_array)-1)];	
}

function rurl() {
  return $_SERVER['HTTP_REFERER'];
}

function cnSub($str,$len){
  return cnSubStr($str,0,$len);
}

function cnSubByChar($str,$len) {
  return cnSubstrByChar($str,0,$len);
}

function cnSubstrByChar($str,$start,$len) {  
  $tmpstr = ""; 
  $strlen = $start + $len; 
  $i = 0;  
  $n = $pos = 0;   
  while( $n < $strlen ){   
    $ascnum = ord(substr($str, $i, 1)) ;      
    if( $ascnum > 224) { 
      $step = 3;
      $pos += 3;
    }elseif ($ascnum>=192) {
      $step = 2;      
      $pos += 2;
    }elseif ($ascnum >0) {
      $step = 1;      
      $pos += 1;
    } else {
      break;
    }
    if( $n >= $start ){
      $tmpstr .= substr($str, $i, $step); 
    }
    $i += $step;    
    $n ++;
  }
  if( $i<strlen($str) ){
    $tmpstr .= "…";   
  }   
  return $tmpstr; 

}

/* substr by byte  not character */
function cnSubstr($str, $start, $len) { 
  $tmpstr = ""; 
  $strlen = $start + $len; 
  $i = 0;  
  $n = $pos = 0;   
  while( $n < $strlen ){   
    $ascnum = ord(substr($str, $i, 1)) ;      
    if( $ascnum > 224) { 
      $step = 3;
      $pos += 3;
    }elseif ($ascnum>=192) {
      $step = 2;      
      $pos += 2;
    }elseif ($ascnum >0) {
      $step = 1;      
      $pos += 1;
    } else {
      break;
    }
    if( $n >= $start ){
      $tmpstr .= substr($str, $i, $step); 
    }
    $i += $step;    
//    if( $pos%3 == 0){
    if( $pos >= 3 ){
      $n ++;
      $pos = 0;
    }
  }
  if( $i<strlen($str) ){
    $tmpstr .= "…";   
  }   
  return $tmpstr; 
}

function _debug($s) {
	print_r($s);
	print_r("<br/>");
}
