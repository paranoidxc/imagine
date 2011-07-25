<?php

class RelController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionPickImage(){		
		$return_id = $_GET['return_id'];
		$rtype = $_GET['rtype'];
		$criteria=new CDbCriteria;

		if( isset($_GET['keyword']) ){
		  $screen_name = trim($_GET['keyword']);		  
		  $criteria->condition  = 'screen_name like :screen_name';
      $criteria->params     = array(':screen_name'=>"%$screen_name%");
      $partial_tpl = '_image';
		}else{
		  $partial_tpl = 'pickimage';
		}
    $criteria->order =' c_time DESC';

		$item_count = Attachment::model()->count($criteria);    
    $page_size = 10;          
    $pages =new CPagination($item_count);
    $pages->setPageSize($page_size);      
    $pagination = new CLinkPager();
		$pagination->header='';
    $pagination->cssFile=false;
    $pagination->setPages($pages);    
    $pagination->init();      
    $criteria->limit        =  $page_size;
    $criteria->offset       = $pages->offset;
    $select_pagination = new  CListPager();    
    $select_pagination->htmlOptions['onchange']=""; 
    $select_pagination->header = '<span>跳到:</span>';
    $select_pagination->setPages($pages);    
    $select_pagination->init(); 
    $atts = Attachment::model()->findAll( $criteria );
    $this->renderPartial($partial_tpl,array(
	    'return_id' => $return_id,
	    'atts' => $atts,
	    'rtype' => $rtype,
      'pagination' => $pagination, 'select_pagination' => $select_pagination 
      ),false,true);
	}
	
	public function actionPickAtt(){		
		$return_id = $_GET['return_id'];
		$rtype = $_GET['rtype'];
		$criteria=new CDbCriteria;

		if( isset($_GET['keyword']) ){
		  $screen_name = trim($_GET['keyword']);		  
		  $criteria->condition  = 'screen_name like :screen_name';
      $criteria->params     = array(':screen_name'=>"%$screen_name%");
      $partial_tpl = '_att';
		}else{
		  $partial_tpl = 'pickatt';
		}
    $criteria->order =' c_time DESC';
		$item_count = Attachment::model()->count($criteria);    
    $page_size = 10;          
    $pages =new CPagination($item_count);
    $pages->setPageSize($page_size);      
    $pagination = new CLinkPager();
    $pagination->cssFile=false;
    $pagination->setPages($pages);    
    $pagination->header='';
    $pagination->init();      
    $criteria->limit        =  $page_size;
    $criteria->offset       = $pages->offset;
    $select_pagination = new  CListPager();    
    $select_pagination->htmlOptions['onchange']="";
    $select_pagination->setPages($pages);     
    $select_pagination->header = '<span>跳到:</span>';
    $select_pagination->init(); 
    $atts = Attachment::model()->findAll( $criteria );
    $this->renderPartial($partial_tpl,array(
	    'return_id' => $return_id,
	    'atts' => $atts,
	    'rtype' => $rtype,
      'pagination' => $pagination, 'select_pagination' => $select_pagination 
      ),false,true);
	}
	
	public function actionPicknode(){
		$return_id =& $_GET['return_id'];
		$rtype     =& $_GET['rtype'];
    $tpl = 'picknode';
    if( $rtype == "multiple") {
      $tpl = 'multiple_node';
    }
    $top_leaf_id = $_GET['top_leaf_id'];
    if( strlen($top_leaf_id) > 0 ) {
	    $nodes  = Category::model()->ileafs( array( 'id' => $top_leaf_id,'include' => true ));
    }else{
	    $nodes  = Category::model()->ileafs( array( 'ident' => 'attachment','include' => true ));
    }

    $this->renderPartial($tpl,array('nodes' => $nodes,'return_id' => $return_id),false,true);	
	}
	
}
