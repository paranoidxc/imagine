<?php
class API {  
  public static $IMAGE_EXTENSION  = array("jpg", "jpeg", "png", "gif");      
  public static $ATT_IMG_AUTO_SIZE = array(
      array( 'size' => '800_500','radio' => "" ),
      array( 'size' => '604_454','radio' => "h" ),
      array( 'size' => '157_250','radio' => "w" ),
      array( 'size' => '160_120','radio' => "", 'is_thumb' => true ),
      array( 'size' => '142_95', 'radio' => "h",'is_thumb' => true ),
      array( 'size' => '100_65', 'radio' => "w",'is_thumb' => true ),
      array( 'size' => '48_48',  'radio' => "", 'is_thumb' => true ) );

  public static function isaction($uri) {
    $r = '';
    if( is_array($uri) ) {
      foreach( $uri as $u ) {
        if( strpos($_SERVER['REQUEST_URI'], $u ) !== false ) {
          $r = ' select on ';
          break;
        }
      }
    }else{
      $r = strpos($_SERVER['REQUEST_URI'], $uri ) !== false  ? ' select on ' : '';
    }
    return $r;
  }

  public static function lchart() {
    return '&nbsp;&laquo;&nbsp;';
  }
  public static function rchart() {
    return '&nbsp;&raquo;&nbsp;';
  }

  public static function lc() {
    return '&laquo;';
  }
 
  public static function rc() {
    return '&raquo;';
  }
 
  public static function upload_prefix_dir() {
    $y = date('Y');
    $m = date('m');
    $d = date('d');
    if( file_exists(ATMS_SAVE_DIR.$y) ){
      if( file_exists(ATMS_SAVE_DIR.$y.'/'.$m) ){
        if( file_exists(ATMS_SAVE_DIR.$y.'/'.$m.'/'.$d) ){
        }else{
          mkdir( ATMS_SAVE_DIR.$y.'/'.$m.'/'.$d, 0777 );
        }
      }else{
        mkdir( ATMS_SAVE_DIR.$y.'/'.$m ,0777 );
        mkdir( ATMS_SAVE_DIR.$y.'/'.$m.'/'.$d ,0777 );
      }
    }else{
      mkdir( ATMS_SAVE_DIR.$y ,0777 );
      mkdir( ATMS_SAVE_DIR.$y.'/'.$m,0777  );
      mkdir( ATMS_SAVE_DIR.$y.'/'.$m.'/'.$d ,0777);
    }    
    return $y.'/'.$m.'/'.$d.'/';
  }

  public static function mysql_version(){    
    $sql = " select version() as version";
    $r = Yii::app()->db->createCommand($sql)->queryAll();    
    return $r[0]['version'];    
  }
    
  public static function get_lang() {
    return Yii::app()->language;
  }  
  
  public static function get_theme_baseurl($prefix=false) {
    if( $prefix ){
      return $prefix.Yii::app()->theme->baseUrl;
    }
    return Yii::app()->theme->baseUrl;
  }

  public static function get_ip(){
    return $_SERVER['SERVER_ADDR'];
  }
  public static function php_version() {
    return PHP_VERSION;
  }
  public static function server_info() {
    return $_SERVER['SERVER_SOFTWARE'];
  }
  public static function server_signature() {
    return $_SERVER['SERVER_SIGNATURE'];
  }
  public static function get_magic_quotes_gpc() {
    return get_magic_quotes_gpc() == 0 ? 'OFF': 'ON';
  }

  public static function server_max_upload_size(){  
    return @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">Null</font>';
  }
  public static function get_upload_files_size() {
    return API::size_format( API::dir_size( ATMS_SAVE_DIR ) );
  }

  public static function size_format($s){
    if ($s<1000) {
      $r =(string)$s.' B';
    }elseif ($s<(1000*1000)) {
      $r=number_format((double)($s/1000),1).' KB';
    }else {
      $r=number_format((double)($s/(1000*1000)),1).' MB';
    }
    return $r;
  }

  public static function dir_size($dir) {
    $handle=opendir($dir);
    $size=0;
    while ($file=readdir($handle)) {
      if (($file==".")||($file=="..")) {continue;}
      if (is_dir("$dir/$file")){
        $size+=API::dir_size("$dir/$file");
      }        
      else{
        $size+=filesize("$dir/$file");
      }
    }
    closedir($handle);
    return $size; 
  }


  public static function articles_ul($category, $option){
    $r = '<ul class="api_chapters_ul" style="text-indent: '.$option['text_indent'].'">';
    if( $category->articles ) {
      foreach( $category->articles as $article ) {                
        $r .= '<li><a href="'.Yii::app()->urlManager->createUrl($option['url'],array('id' => $article->id, 'ajax' => 'ajax' )).'" title="'.$article->title.'" >';
        $r .= $article->title;
        $r .= '</a></li>';
		  }
    }
    $r .= '</ul>';
    return $r;
  }
  
  /**
   * get articles
   * parameter type => category id/ category obj
   * @return pure array data, ul date, 
   * @author paranoid
   **/
  public static function articles($option){        
    $r = '';
    if( is_array($option) ){
      
      if( $option['type'] == 'id' ){        
        $category = Category::model()->findbyPk($_GET['id']);
      }else if ($option['type'] == 'obj'){
        $category = $option['obj'];
      }            
      if( $option['dom'] == 'ul' ){
        $r .= self::articles_ul($category,$option);                
      }
      return $r;                  
    }else{
      echo "API articles Parameter Error!";
      exit;
    }    
  }
  /**
   * get category recursion
   *
   * @return data
   * @author paranoid
   **/
  public static function categorys($option){
    if( is_array( $option) ){            
     $id = $option['id'];
     $depth = $option['depth'];
     $r = Category::model()->vleafs($id, $depth);
     return $r;
    }    
  }
  
  
  public static function leafs() {
    
  }
  
  public static function leaf_tree(){
    
  }  
  
  /**
   * move the leaf to another 
   * @parameter $opt['from] => the id of moving leaf ; $opt['to'] => the parent leaf id 
   * WARNNING: can't move leaf to self
   * @return boolean
   * @author paranoid
   **/
  public static function leaf_move($opt){
    if( is_array($option) && is_numeric($opt['from']) && is_numeric($opt['to']) ){      
      return Category::model()->leafMoveToAnother($opt['from'], $opt['to']);
    }else{
      echo "ERROR PHP File:".dirname(__FILE__).'/API.php';
      echo "ERROR Fuction category_move";
      exit;
    }
  }    

  /**
   * get category recursion
   * @parameter $opt
   * 
   * @return boolean
   * @author paranoid
   **/
  public static function INODE($opt) {
    if( is_array( $opt ) ) {      
      if( strlen($opt['include']) == 0) {
        $opt = array_merge($opt, array('include' => false ) );
      }
      return Category::model()->ileafs($opt);
    }else{
      echo "ERROR PHP File:".dirname(__FILE__).'/API.php';      
      echo "ERROR Fuction INODE";
      exit;
    }
  }
  
  /*
     $opt = array( 'id' => 1 );           return single category obj
     $opt = array( 'id' => '1,2,3' );     return list category obj
     $opt = array( 'ident' => '1' );      reutrn signle category obj
     $opt = array( 'ident' => '1,2,3' );  return list category obj
     $opt = array( 'ident_label' => '1' );      return single category obj
     $opt = array( 'ident_label' => '1,2,3' );  return list category obj
     !!!>> not include sub category in return list category obj
   */
  public static function node($opt) {    
    if( is_array( $opt ) ) {
      return Category::model()->node($opt);
    }else{
      echo "ERROR PHP File:".dirname(__FILE__).'/API.php';      
      echo "ERROR Fuction INODE";
      exit;
    }
  }
  
  public static function essay($opt){
    $order   = empty($opt['order']) ? ' id DESC ' : $opt['order'];
    if( is_array($opt) ){
      if( !empty($opt['id']) ){
        $id = $opt['id'];
        if( strpos($id,',') === false ){
          return Article::model()->findbyPk($id);          
        }else{
          $criteria=new CDbCriteria;
          $criteria->condition  = 'find_in_set(id, :id)';
          $criteria->params     = array(':id'=>$id);
          $criteria->order      = $order;
          $item_count = Article::model()->count($criteria);                              
          $page_size = 2;          
          $pages =new CPagination($item_count);          
          //$pages->pageVar = 'iook=8&ok';          
          $pages->setPageSize($page_size);
          $pagination = new CLinkPager();
          $pagination->setPages($pages);    
          $pagination->init();            
          //$pagination->run(); // display the html pagination
          $criteria->limit        =  $page_size;
          $criteria->offset       = $pages->offset;
          //print_r($page_size);
          //print_r($pages->offset);
          $list = Article::model()->findall( $criteria );
          return array($list, $pagination);                    
        }
      }else if( !empty($opt['ident']) ){
        $ident = $opt['ident'];
        if( strpos($id, ',') === false ) {
          return Article::model()->find( array( 'condition' => ' ident =:ident ', 'params' => array( 'ident' => $ident ) ) );
        }else{
          return Article::model()->findall(array(
            'condition' => 'find_in_set(ident, :ident)',
            'params'=>array(':ident'=>$ident),
            'order' => $order
          ));
        }
      }      
    }else{
      echo "ERROR PHP File:".dirname(__FILE__).'/API.php';      
      echo "ERROR Fuction essay";
      exit;
    }
  }
  
}
?>
