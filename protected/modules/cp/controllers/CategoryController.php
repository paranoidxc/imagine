<?php

class CategoryController extends IController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	//private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('iclass','index','view','leafs','exchange','move','sort','pick','itest','part_leafs'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'iroot', 'inavigation', 'icategory', 'iattachment'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function getRelData() {		
		$_data = Category::model()->getTreeById();
		$leafs = CHtml::listdata($_data, 'id','name');		
		return array( $leafs );
	}
  
	public function actionIclass(){
	  $id     = $_GET['id'];
	  $class  = $_GET['class'];
	  print_r($class);
	  $icat = Yii::app()->user->getState('scategory');
    if( $icat[$id] ){
      $icat[$id]['class'] = $class;
      Yii::app()->user->setState('scategory',$icat);
    }
	}
	
	public function actionPart_leafs(){
		$id = $_GET['top_leaf_id'];		
		$leafs = Category::model()->ileafs(
        array( 'id' => $id ,'include' => true )
	  );
		$this->renderPartial('_test_node',array( 'nodes' => $leafs,'return_id' => 'xxx' ) );
	}
	
	public function actionMove() {
	  $panel_ident = $_REQUEST['panel_ident'];
	  
	  if(Yii::app()->request->isPostRequest){	    	    
      if( Category::model()->leafMoveToAnother($_POST['cur_leaf_id'],$_POST['category_id']) ){
        echo "leaf move suc !" ;        
      }else{
        echo 'leaf move error !';       
      }
      exit;
	  }else{
	     $leafs = Category::model()->ileafs(
        array( 'id' => $_GET['top_leaf_id'],'include' => true )
	    );
		  $this->renderPartial('move', array(
			  'leafs' => $leafs,
			  'panel_ident' => $panel_ident,
		  ),false, true);
		  
	  }
	}
	
	
  public function actionxMove(){
    if(Yii::app()->request->isPostRequest){            
      $source_id  = $_POST['cur_leaf_id'];
      $dest_id    = $_POST['category_id'];      
      
      $model = Category::model()->findByPk($source_id);
      //$dest_leaf = Category::model()->findByPk($dest_id);
      $model->parent_leaf = Category::model()->findByPk($dest_id);      
			
			$width = $model->rgt - $model->lft + 1;
			$pwidth = $model->parent_leaf->rgt - $model->parent_leaf->lft ;
			
			if( $pwidth < $width ) {
				$pwidth = $pwidth + $width;
			}
			
			$cmodel = Category::model();
			$transaction = $cmodel->dbConnection->beginTransaction();		
      try{
				// step 1: temporary "remove" moving node
		    $sql 	 = " UPDATE category ";
  			$sql	.= " SET lft = -lft, rgt = -rgt ";
  			$sql	.= " WHERE lft >= $model->lft AND rgt <= $model->rgt ";
  			_debug($sql);
  			$cmodel->dbConnection->createCommand($sql)->execute(); 	    			
 
  			// step 2: decrease left and/or right position values of currently 'lower' items (and parents)
  			$width = abs($width);
  			$pwidth = abs($pwidth);
      	$sql = " UPDATE category  SET lft = lft  -  $width WHERE lft > $model->rgt ";	   
      	$cmodel->dbConnection->createCommand($sql)->execute(); 	
  	    $sql = " UPDATE category SET rgt = rgt- $width WHERE rgt >  $model->rgt ";
  	    $cmodel->dbConnection->createCommand($sql)->execute();
  	    
  	    //// step 3: increase left and/or right position values of future 'lower' items (and parents)
  			$parent_rgt = $model->parent_leaf->rgt;
  			$parent_lft = $model->parent_leaf->lft;
			
			  $t1 = $parent_rgt > $model->rgt ? $parent_rgt -$width : $parent_rgt;
			  $sql = " UPDATE category SET lft = lft + $width  WHERE lft >= $t1 ";
    	  _debug($sql);
    	  _debug( " t1 = ".$t1);
    	  $cmodel->dbConnection->createCommand($sql)->execute();    	    	    	
    	
      	$t2 = $parent_rgt > $model->rgt ? $parent_rgt - $width : $parent_rgt;
      	_debug( " t2 = ".$t2);
      	$sql = " UPDATE category  SET rgt = rgt +  $width WHERE rgt >=  $t2";
      	$cmodel->dbConnection->createCommand($sql)->execute();	    	    	    	    
      	
      	// step 4 move the temporary "remove" leaf to parent
      	$_lft = $parent_rgt > $model->rgt ? $parent_rgt - $model->rgt -1 : $parent_rgt-$model->rgt -1 + $width;
      	$_rgt = $parent_rgt > $model->rgt ? $parent_rgt - $model->rgt -1 : $parent_rgt-$model->rgt -1 + $width;
      	$sql = " UPDATE category SET lft = -lft + $_lft , rgt = -rgt + $_rgt WHERE lft < 0 ";    	    	
      	_debug( $sql );

      	$cmodel->dbConnection->createCommand($sql)->execute();
  	    $transaction->commit();		
	      
      }catch(Exception $e) {
    	  _debug($e);
      	$transaction->rollBack();
      }
      
    }else{      
      $leafs = Category::model()->ileafs(
        array( 'id' => $_GET['top_leaf_id'],'include' => true )
	    );	  
	  
		  $this->renderPartial('move', array(
			  'leafs' => $leafs
		  ),false, true);
    }
    
  }
  
  
	public function actionPick(){
		$return_id = $_GET['return_id'];
		$this->renderPartial('pick',array('return_id' => $return_id),false,true);	
	}
	/**
	 * Category sort function
	 * id1 => destination category/leaf
	 * id2 => drag/source category/leaf
	 * id1, id2 must in the same hiierarchical
	 * darg < desc , sort like this : middle_leaf, desc_leaf, drag_leaf
	 * darg > desc , sort like this : desc_leaf, drag_leaf, middle_leaf
	 * @return void
	 * @author paranoid
	 **/
	public function actionSort() {		
	  if( $_GET['id2'] == -1 ){
	    
	    $drag_leaf = Category::model()->findByPk($_GET['id1']);  
	    $cmodel = Category::model();	    	    
	    $drag_parent = $cmodel->directParent($drag_leaf->id);
	    
	    $transaction = $cmodel->dbConnection->beginTransaction();
	    try{	      
	      $drag_leaf_width = $drag_leaf->rgt + 1 - $drag_leaf->lft;        
        $drag_lft = $drag_leaf->lft;
				$drag_rgt = $drag_leaf->rgt;      
        
        $drag_final_width =  ($drag_parent->lft+ 1) -$drag_leaf->lft;
                
      	//temp the drag_leaf			
				$sql 	 = " UPDATE category ";
  		 	$sql	.= " SET lft = -lft, rgt = -rgt ";
  		 	$sql	.= " WHERE lft >= $drag_leaf->lft AND rgt <= $drag_leaf->rgt ";  		 	
  		 	$cmodel->dbConnection->createCommand($sql)->execute();
  		 	
  		 	$sql  = " UPDATE category ";
  		 	$sql .= " SET lft = lft + $drag_leaf_width, rgt = rgt + $drag_leaf_width";
    		$sql .= " WHERE lft > $drag_parent->lft AND rgt <= $drag_rgt";  		 	
    		
    		$cmodel->dbConnection->createCommand($sql)->execute();
    		
    		
    		//reset the drag_leaf
    		
		 		$sql = " UPDATE category ";
  		 	$sql.= " SET lft = -lft + $drag_final_width , rgt = -rgt + $drag_final_width ";
  		 	$sql.= " WHERE lft BETWEEN -$drag_rgt AND -$drag_lft";
  		 	
  		 	$cmodel->dbConnection->createCommand($sql)->execute();    		 	
  		 	$transaction->commit();	 	 
      }catch(Exception $e) {
        echo "FFFFF";
      }
	    exit;
	  }
	  
		$dest_leaf = Category::model()->findByPk($_GET['id2']);
		$drag_leaf = Category::model()->findByPk($_GET['id1']);
		$cmodel = Category::model();
		$dest_parent = $cmodel->directParent($dest_leaf->id);
		$drag_parent = $cmodel->directParent($drag_leaf->id);
		if( $dest_parent->id != $drag_parent->id ){	
			echo 'STOP';
			exit;
		}else{
			
			if( $drag_leaf->lft < $dest_leaf->lft ){
				$transaction = $cmodel->dbConnection->beginTransaction();
				try{
				  $drag_lft = $drag_leaf->lft;
				  $drag_rgt = $drag_leaf->rgt;
					$middle_leaf_lft = $drag_leaf->rgt+1;
					$middle_leaf_rgt = $dest_leaf->lft-1;
					$width = $middle_leaf_lft - $drag_leaf->lft;										
					$drag_final_width = $dest_leaf->rgt-$width + 1 - $drag_leaf->lft;
					//temp the drag_leaf			
					$sql 	 = " UPDATE category ";
    		 	$sql	.= " SET lft = -lft, rgt = -rgt ";
    		 	$sql	.= " WHERE lft >= $drag_leaf->lft AND rgt <= $drag_leaf->rgt ";
    		 	$cmodel->dbConnection->createCommand($sql)->execute();    		 	
    		 	// move middle, dest leaf forward width step
    		 	$sql 	 = " UPDATE category ";
    		 	$sql	.= " SET lft = lft-$width, rgt = rgt-$width ";
    		 	$sql 	.= " WHERE lft BETWEEN $middle_leaf_lft AND $dest_leaf->rgt-1 ";
    		 	$cmodel->dbConnection->createCommand($sql)->execute();    		 	
    		 	// reset the drag below the dest 
    		 	$sql = " UPDATE category ";
    		 	$sql.= " SET lft = -lft + $drag_final_width , rgt = -rgt + $drag_final_width ";
    		 	$sql.= " WHERE lft BETWEEN -$drag_rgt AND -$drag_lft";
    		 	$cmodel->dbConnection->createCommand($sql)->execute();    		 	
    		 	$transaction->commit();	 	    		 	
				}catch(Exception $e) {				  
					$transaction->rollBack();
				}
			}else{				
				$transaction = $cmodel->dbConnection->beginTransaction();	
				try{
					$drag_lft = $drag_leaf->lft;
				  $drag_rgt = $drag_leaf->rgt;
					$middle_leaf_lft = $dest_leaf->rgt+1;
					$middle_leaf_rgt = $drag_leaf->lft-1;
					$width = $drag_leaf->lft - $middle_leaf_lft;
					$middle_final_width = $drag_leaf->rgt-$width + 1 - $middle_leaf_lft;
					
					// temp the middle
					$sql 	 = " UPDATE category ";
    		 	$sql	.= " SET lft = -lft, rgt = -rgt ";
    		 	$sql	.= " WHERE lft >= $middle_leaf_lft AND rgt <= $middle_leaf_rgt ";    		 	
    		 	$cmodel->dbConnection->createCommand($sql)->execute();					
					
					// move drag forward width step
					$sql 	 = " UPDATE category ";
    		 	$sql	.= " SET lft = lft-$width, rgt = rgt-$width ";
    		 	$sql 	.= " WHERE lft BETWEEN $drag_leaf->lft AND $drag_leaf->rgt-1 ";    		 	
    		 	$cmodel->dbConnection->createCommand($sql)->execute();
    		 	
    		 	// reset the middle
    		 	$sql = " UPDATE category ";
    		 	$sql.= " SET lft = -lft + $middle_final_width , rgt = -rgt + $middle_final_width ";
    		 	$sql.= " WHERE lft BETWEEN -$middle_leaf_rgt AND -$middle_leaf_lft";    		 	    		 	    		 	
    		 	$cmodel->dbConnection->createCommand($sql)->execute();	     		 	
    		 	$transaction->commit();	 	
					
				}catch(Exception $e) {							
				$transaction->rollBack();
				}	
			}
			
		}	
	}
	
	public function actionExchange() {	 

		$leaf1 = Category::model()->findByPk($_GET['id2']);
		$leaf1_dis = $leaf1->rgt - $leaf1->lft;
		$leaf2 = Category::model()->findByPk($_GET['id1']);
		$leaf2_dis = $leaf2->rgt - $leaf2->lft;
		
		$cmodel = Category::model();		
		$leaf1_parent = $cmodel->directParent($leaf1->id);
		$leaf2_parent = $cmodel->directParent($leaf2->id);
		echo "LEAF 1 ID: ";
		echo $leaf1_parent->id;
		echo "\n LEAF 2 ID: ";
		echo $leaf2_parent->id;
		if( $leaf1_parent->id != $leaf2_parent-> $id ){
			//echo 'cancel not the same parent!';
			echo 'STOP';
			exit;
		}
		echo $_GET['id1'];
		echo '--';
		echo $_GET['id2'];
		echo '---';
		echo $leaf1->lft;
		echo '---';
		echo $leaf2->lft;
		
		$transaction = $cmodel->dbConnection->beginTransaction();	
		try{
		if( $leaf1->lft < $leaf2->lft ){
			 echo "<";
			
			$width = $leaf2_dis - $leaf1_dis;
			
			$middle_lft = $leaf1->rgt +1;
			$middle_rgt = $leaf2->lft -1;				
			$middle_rgt_final = $middle_rgt + $width;
			$middle_lft_final = $middle_lft + $width;
			$leaf1_width = $middle_rgt_final+1 - $leaf1->lft;
			$leaf2_width = $leaf2->rgt - ($middle_lft_final-1);
			
			$leaf1_rgt = $leaf1->rgt;
			$leaf1_lft = $leaf1->lft;
			
			$leaf2_rgt = $leaf2->rgt;
			$leaf2_lft = $leaf2->lft;
			
			echo "temp leaf2";
			 //temp the leaf2
			 $sql 	 = " UPDATE category ";
    		 $sql	.= " SET lft = -lft, rgt = -rgt ";
    		 $sql	.= " WHERE lft >= $leaf2->lft AND rgt <= $leaf2->rgt ";
    		 $cmodel->dbConnection->createCommand($sql)->execute();
    		
    		 echo "temp leaf1";
    		 //temp the leaf1
			 $sql 	 = " UPDATE category ";
    		 $sql	.= " SET lft = -lft, rgt = -rgt ";
    		 $sql	.= " WHERE lft >= $leaf1->lft AND rgt <= $leaf1->rgt ";
    		 $cmodel->dbConnection->createCommand($sql)->execute();
    		 
			//更新中间部分
			$sql = " UPDATE category  SET lft = lft  +  $width , rgt = rgt + $width WHERE lft BETWEEN $leaf1_rgt+1 AND $leaf2_lft-1 ";	
			echo $sql;
			echo "\n";
			$cmodel->dbConnection->createCommand($sql)->execute();
			
			//跟新leaf1			
			$sql = " UPDATE category  SET lft = -lft  +  $leaf1_width , rgt = -rgt + $leaf1_width WHERE lft BETWEEN -$leaf1_rgt  AND -$leaf1_lft";
			echo $sql;
			echo "\n";
			$cmodel->dbConnection->createCommand($sql)->execute();		
							
			//跟新leaf2			
			$sql = " UPDATE category  SET lft = -lft  -  $leaf2_width , rgt = -rgt - $leaf2_width WHERE lft BETWEEN -$leaf2_rgt AND -$leaf2_lft ";
			echo $sql;
			echo "\n";
			$cmodel->dbConnection->createCommand($sql)->execute();		
			$transaction->commit();
		}else{
			echo ">";
			$width = $leaf2_dis - $leaf1_dis;
		}	
		}catch(Exception $e) {							
			$transaction->rollBack();
		}	
			
		
		
		echo "ID1:";
		echo $_GET['id1'];
		echo $leaf1->name;		
		
		
		echo '--';
		echo "ID2:";
		echo $_GET['id2'];
		echo $leaf2->name;
		
	}
	
	
	public function actionIroot(){
	  $this->irun('ROOT');
	}
	public function actionInavigation(){	  
	  $this->irun('navigation');
	}
	public function actionIcategory(){
	  $this->irun('category');
	}
	public function actionIattachment(){	  
	  $this->irun('attachment');
	}
	
	public function irun($ident) {	  
	  $leafs = Category::model()->ileafs(
        array( 'ident' => $ident ,'include' => true )
	  );
	  $top_leaf = $model = Category::model()->find('ident = :ident', array( ':ident' => $ident) );	  	  
    
	  if( $_GET['ajax'] == 'ajax' ){
	    $this->renderPartial('itest',array(
				'leafs'     => $leafs,
				'top_leaf'  => $top_leaf
			),false,true);
	    /*
	    $this->renderPartial('_leafs',array(
				'leafs'     => $leafs,
				'top_leaf'  => $top_leaf
			),false,true);
			*/
	  }else{
	    $this->render('itest',array(
				'leafs'     => $leafs,
				'top_leaf'  => $top_leaf
			));
	  }
	}
	
	public function actionItest() {
	  $ident = $_GET['ident'] ? $_GET['ident'] : 'ROOT';
	  $leafs = Category::model()->ileafs(
        array( 'ident' => $ident ,'include' => true )
	  );
	  if( $_GET['ajax'] == 'ajax' ){
	    $this->renderPartial('_leafs',array(
				'leafs'=> $leafs
			),false,true);
	  }else{
	    $this->render('itest',array(
				'leafs'=> $leafs
			));
	  }
	}
	
	public function actionLeafs() {	  
	  $ident = $_GET['ident'] ? $_GET['ident'] : 'ROOT';
	  $leafs = Category::model()->ileafs(
        array( 'ident' => $ident ,'include' => true )
	  );
	  if( $_GET['ajax'] == 'ajax' ){
	    $this->renderPartial('_leafs',array(
				'leafs'=> $leafs
			),false,true);
	  }else{
	    $this->render('leafs',array(
				'leafs'=> $leafs
			));
	  }
	}
	
	
	public function actionLeafsBak() {			  
		$sql = 	" SELECT node.id AS id, ".
      		 	" node.name, (COUNT(parent.name) - 1) AS depth, node.lft, node.rgt ".
        		" FROM category AS node,".
        		" category AS parent ".
        		" WHERE node.lft BETWEEN parent.lft AND parent.rgt ".
        		" GROUP BY node.id ".
	        	" ORDER BY node.lft ";        
		$leafs =Category::model()->findAllBySql($sql);
		if($_GET['ajax'] == 'ajax') {
		  $this->renderPartial('_leafs',array(
				'leafs'=> $leafs
			),false,true);		
		}else{
			$this->render('leafs',array(
				'leafs'=> $leafs
			));		
		}
	}
	
	
	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{  
		$criteria = new CDbCriteria;		
		$model=$this->loadModel();
		$keyword = trim($_GET['keyword']);	
		$criteria->params  = array();
		$is_include = $_GET['is_include'];
		$criteria->condition  = ' find_in_set(category_id, :category_id)';
		if( $is_include ) {		  
      $leafs = Category::model()->findAll( array( 
        'select' => 'id, name',
        'condition'  => ' rgt <= :rgt AND lft >= :lft ',
        'params'    => array( ':rgt' => $model->rgt, ':lft' => $model->lft )
      ) );
      $all_leafs = '';
      foreach( $leafs as $_leaf ){
        $all_leafs .= $_leaf->id.',';
      }        
      $criteria->params[':category_id'] = $all_leafs;
		}else{      
      $criteria->params[':category_id'] = $model->id;
		}
		if( $_GET['model_type'] == 'attachment' ){
		  $opt['tpl'] = 'ajaxview_attachment';
		  $opt['controllerId'] = 'Attachment';
		  if( strlen( $keyword ) > 0 ){
	      $criteria->condition .= " AND t.screen_name like :keyword ";
	      $criteria->params[':keyword'] = "%$keyword%";
	    }
	  }else{	    
	    $opt['tpl'] = 'ajaxview';
	    $opt['controllerId'] = 'Article';		  
	    if( strlen( $keyword ) > 0 ){
	      $criteria->condition .= " AND t.title like :keyword ";
	      $criteria->params[':keyword'] = "%$keyword%";
	    }
	    $criteria->order      = 'create_time DESC';
	    $criteria->order=" t.sort_id DESC ";
	    $opt['page_size'] = 12;
	  }
		$opt['criteria'] =  $criteria;		
		$opt['tpl_params']['model'] = $model;
		parent::actionIndex($opt);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Category();
		$panel_ident = $_REQUEST['panel_ident'];
		if( isset( $_GET['leaf_id'] ) ) {
			$model->parent_leaf_id = $_GET['leaf_id'];
			$model->parent_leaf = Category::model()->findByPk($_GET['leaf_id']);			
		}		
    $panel_ident = $_REQUEST['panel_ident'];
    
		if(isset($_POST['Category']))
		{
		  $model->attributes=$_POST['Category'];
			// ==2 is pass the validate 
			// validate reutrn "[]" string
			if( strlen(CActiveForm::validate($model)) == 2 ) {
				
				$cmodel = Category::model();
				$transaction = $cmodel->dbConnection->beginTransaction();				
				try {          
					$leaf_model = Category::model();								
					
					$parent_leaf = $leaf_model->find('id = :id', array( ':id'=> $_POST['Category']['parent_leaf_id']) );

					$update_rgt = " UPDATE category SET rgt = rgt + 2 WHERE rgt > $parent_leaf->lft ";
					$cmodel->dbConnection->createCommand($update_rgt)->execute();
          
					$update_lft = " UPDATE category SET lft = lft + 2 WHERE  lft > $parent_leaf->lft ";					
					$cmodel->dbConnection->createCommand($update_lft)->execute();					
				
					$model->lft = $parent_leaf->lft + 1;
					$model->rgt = $parent_leaf->lft + 2;
				
					$model->create_time = date("Y-m-d H:i:s");
				
					$model->save();
					$transaction->commit();	
					
					if( $_GET['ajax'] == 'ajax' ) {
					  $str = Yii::t('cp','Create Success On ').Time::now();
					  Yii::app()->user->setFlash('success',$str);
						$this->renderPartial('create_next',array( 'model' => $model, 'panel_ident' =>  $panel_ident) ,false, true );			
						exit;			
					}else {							
						$this->redirect(array('leafs'));
					}
				}catch(Exception $e) {
				//	print($e);
					print(" exception ");					
					$transaction->rollBack();
				}				
			}
		}
		if( empty($model->content_type) ){
		  $model->content_type = 1;  
		}
		if( $_GET['ajax'] == 'ajax' ) {
			$this->renderPartial('create', array(
				'model'       => $model,
				'model_type'  => $_GET['model_type'],
				'panel_ident' => $panel_ident,
				'ajax'        => true
			), false, true );			
		}else {					
			$this->render('create',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */	
	
	public function actionxUpdate()
	{
		$model=$this->loadModel();

		list( $leafs  )= $this->getRelData();		

		//if( isset( $_POST['']['leaf_id'] ) ) {
		//if( isset( $_GET['leaf_id'] ) ) {
		if( isset( $_POST['Category']['parent_leaf_id'] ) ) {			
			//$model->parent_leaf_id = $_GET['leaf_id'];
			//$model->parent_leaf = Category::model()->findByPk($_GET['leaf_id']);			
			$model->parent_leaf_id = $_POST['Category']['parent_leaf_id'];
			$model->parent_leaf = Category::model()->findByPk($_POST['Category']['parent_leaf_id']);			
		} else {			
			$sql = 	" SELECT parent.name, parent.id ".
				 	" FROM category AS node,".
					" category AS parent ".
					" WHERE node.lft BETWEEN parent.lft AND parent.rgt ".
					" AND node.id = $model->id ".
					" ORDER BY parent.lft ";
					echo $sql;
			$path = Category::model()->findAllBysql($sql);
			$temp_parent;
			foreach( $path as $obj ) {								
				if( $obj->id  == $model->id ) {					
					break;
				}				
				$model->parent_leaf = $obj;
				$model->parent_leaf_id = $obj->id;
			}
		}
		
		//print_r($model->parent_leaf_id);
		//exit;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']) && strlen(CActiveForm::validate($model)) == 2 )
		{			
			$model->attributes=$_POST['Category'];
			$width = $model->rgt - $model->lft + 1;
			$pwidth = $model->parent_leaf->rgt - $model->parent_leaf->lft ;
			if( $pwidth < $width ) {
				$pwidth = $pwidth + $width;
			}
			$cmodel = Category::model();
			$transaction = $cmodel->dbConnection->beginTransaction();		
			try{	
			// step 1: temporary "remove" moving node	
					
					$model->save();
					
			    $sql 	 = " UPDATE category ";
    			$sql	.= " SET lft = -lft, rgt = -rgt ";
    			$sql	.= " WHERE lft >= $model->lft AND rgt <= $model->rgt ";
    			_debug($sql);
    			$cmodel->dbConnection->createCommand($sql)->execute(); 	    			
 
			// step 2: decrease left and/or right position values of currently 'lower' items (and parents)
			
			$width = abs($width);
			$pwidth = abs($pwidth);
    	_debug('width'.$width);
    	_debug('pwidth'.$pwidth);
    	
    	$sql = " UPDATE category  SET lft = lft  -  $width WHERE lft > $model->rgt ";	   
    	$cmodel->dbConnection->createCommand($sql)->execute(); 	
	    $sql = " UPDATE category SET rgt = rgt- $width WHERE rgt >  $model->rgt ";
	    $cmodel->dbConnection->createCommand($sql)->execute();
			
	  
	    //// step 3: increase left and/or right position values of future 'lower' items (and parents)
			$parent_rgt = $model->parent_leaf->rgt;
			$parent_lft = $model->parent_leaf->lft;
			
			
			$t1 = $parent_rgt > $model->rgt ? $parent_rgt -$width : $parent_rgt;
			$sql = " UPDATE category SET lft = lft + $width  WHERE lft >= $t1 ";
    	
    	_debug($sql);
    	$cmodel->dbConnection->createCommand($sql)->execute();    	    	    	
    	
    	$t2 = $parent_rgt > $model->rgt ? $parent_rgt - $width : $parent_rgt;
    	$sql = " UPDATE category  SET rgt = rgt +  $width WHERE rgt >=  $t2";
    	$cmodel->dbConnection->createCommand($sql)->execute();	    	    	    	    
    	
    	// step 4 move the temporary "remove" leaf to parent    	
    	//$sql = " UPDATE category SET lft = -lft + $pwidth, rgt = -rgt + $pwidth WHERE lft < 0 ";    	    	
    	
    	$_lft = $parent_rgt > $model->rgt ? $parent_rgt - $model->rgt -1 : $parent_rgt-$model->rgt -1 + $width;
    	$_rgt = $parent_rgt > $model->rgt ? $parent_rgt - $model->rgt -1 : $parent_rgt-$model->rgt -1 + $width;
    	$sql = " UPDATE category SET lft = -lft + $_lft , rgt = -rgt + $_rgt WHERE lft < 0 ";    	    	
    	_debug( $sql );
    	
    	$cmodel->dbConnection->createCommand($sql)->execute();
	    $transaction->commit();		    		    			
    }catch(Exception $e) {
    	_debug($e);
    	$transaction->rollBack();
    }            
    if( isset($_GET['ajax']) ) {
    	echo 'update leaf suc';
    	exit;
    }else {
    	$this->redirect(array('view','id'=>$model->id));
    }
		//if($model->save())
			//$this->redirect(array('view','id'=>$model->id));
	}

				
		if( isset($_GET['ajax']) ) {
			$this->renderPartial('update', array(
				'model' => $model,
				'leafs'	=> $leafs,
				'ajax'	=> 'ajax'
				),false,true);
		}else {					
			$this->render('update',array(
				'model'=>$model,
			));
		}
	}
	
	
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$panel_ident = $_REQUEST['panel_ident'];
		if( isset( $_POST['Category']['parent_leaf_id'] ) &&  strlen($_POST['Category']['parent_leaf_id']) > 0 ) {		
			$model->parent_leaf_id = $_POST['Category']['parent_leaf_id'];						
			$model->parent_leaf = Category::model()->findByPk($_POST['Category']['parent_leaf_id']);				
		} else {		  
			$sql = 	" SELECT parent.name, parent.id ".
				 	" FROM category AS node,".
					" category AS parent ".
					" WHERE node.lft BETWEEN parent.lft AND parent.rgt ".
					" AND node.id = $model->id ".
					" ORDER BY parent.lft ";					
			$path = Category::model()->findAllBysql($sql);
			$temp_parent;
			foreach( $path as $obj ) {								
				if( $obj->id  == $model->id ) {					
					break;
				}				
				$model->parent_leaf = $obj;		
			}			
		}		

		if(isset($_POST['Category']))
		{		  
			$model->attributes=$_POST['Category'];		
			$model->update_time = date("Y-m-d H:i:s");
			if($model->save()){
			  if( isset($_GET['ajax']) ) {      	  
    	    $str = Yii::t('cp','Data saved success On ').Time::now();
					Yii::app()->user->setFlash('success',$str);
					$is_update = true;
        }else {
    	    $this->redirect(array('view','id'=>$model->id));
        }
			}
		}    
    
		if( isset($_GET['ajax']) ) {
			$this->renderPartial('update', array(
				'model'       => $model,
				'model_type'	=> $_GET['model_type'],
				'is_update'   =>  $is_update,
				'ajax'	      => 'ajax',
				'panel_ident' => $panel_ident
				),false,true);
		}else {					
			$this->render('update',array(
				'model'=>$model,
			));
		}

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{		
		$cmodel = Category::model();
		$transaction = $cmodel->dbConnection->beginTransaction();		
		try {			
			$model = $this->loadModel();	
			$width = $model->rgt - $model->lft + 1;
			
			// delete all leaf where lft between lft and rgt 
			// this will delete the leaf and children
			
			$del_sql = ' DELETE FROM '.$model->tableName().' WHERE lft BETWEEN '.$model->lft.' AND '.$model->rgt;			
			$cmodel->dbConnection->createCommand($del_sql)->execute();			
						
			$update_sql = ' UPDATE '.$model->tableName().' SET rgt = rgt - '.$width.' WHERE rgt > '.$model->rgt;
			$cmodel->dbConnection->createCommand($update_sql)->execute();
			
			$update_sql = ' UPDATE '.$model->tableName().' SET lft = lft - '.$width.' WHERE lft > '.$model->rgt;
			$cmodel->dbConnection->createCommand($update_sql)->execute();

			$transaction->commit();	
			
			//$this->redirect(array('leafs'));
			echo 'delete suc';
			
		}catch(Exception $e) {
			_debug($e);
			$transaction->rollBack();
		}																		
		
		
		$update_sql = ' UPDATE '.$model->tableName().' SET rgt = rgt - :width WHERE rgt > :rgt';
		
		$update_sql = ' UPDATE '.$model->tableName().' SET lft = lft - :width WHERE lft > :rgt';
		exit;
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();						

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect( array('leafs') );
		exit;
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Category::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
