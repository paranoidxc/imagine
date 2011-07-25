<?php

class ArticleController extends GController
{  
  
  public function actionPreview() {
    echo ereg_replace('<script.*</script>', '', Markdown($_POST['content']));
  }
  
	public function getRelData() {		
		$_data = Category::model()->getTreeById();
		$leafs = CHtml::listdata($_data, 'id','name');		
		//array_unshift( $leafs , array( '--ALL Nodes--' ) );
		return array( $leafs );
	}

  public function getTree($top_leaf='') {
    if( strlen($top_leaf) > 0 ) {
      return Category::model()->ileafs( array( 'id' => $top_leaf ,'include' => true ) );
    }else{
      return Category::model()->ileafs( array( 'ident' => 'Root' ,'include' => true ) );
    }
  }
	
	public function actionSortarticle() {
		$sort = $_POST['sort'];
		for( $i=0; $i<count($sort); $i++ ) {		
		  //echo $sort[$i];
			$at = Article::model()->findByPk($sort[$i]);
			$at->sort_id = count($sort)-$i;
			$at->save();
		}
	}
	
  public function actionSlideshow() {
    $top_leaf_id = 276;
    $cur_leaf_id = $_GET['category_id'] ? $_GET['category_id'] : $top_leaf_id;
    $this->actionIndex($top_leaf_id,$cur_leaf_id);
  }
  public function actionIpage() {
    $top_leaf_id = 208;
    $cur_leaf_id = $_GET['category_id'] ? $_GET['category_id'] : $top_leaf_id;
    $this->actionIndex($top_leaf_id,$cur_leaf_id);
  }

  public function actionNews() {
    $top_leaf_id = 235;
    $cur_leaf_id = $_GET['category_id'] ? $_GET['category_id'] : $top_leaf_id;
    $this->actionIndex($top_leaf_id,$cur_leaf_id);
  }


  public function actionInnode() {
    $top_leaf_id = 206;
    $cur_leaf_id = $_GET['category_id'] ? $_GET['category_id'] : $top_leaf_id;
    $this->actionIndex($top_leaf_id,$cur_leaf_id);
  }


	public function actionIndex($top_leaf_id='',$cur_leaf_id='') {	  
    // fetch top leaf
    if( strlen($top_leaf_id) > 0 ) {
      $top_leaf = Category::model()->findByPk($top_leaf_id);
    }else{
      $top_leaf = Category::model()->findByPk(1);
    }
    // fetch current leaf
    if( strlen(trim($cur_leaf_id)) > 0 ) {
      $cur_leaf = $category = Category::model()->findByPk($cur_leaf_id);
    }else{
      $cur_leaf_id =  (strlen($_GET['category_id']) > 0 ) ? $_GET['category_id'] : 1;
      $cur_leaf = $category = Category::model()->findByPk($cur_leaf_id);
    }
 
    $this->path = Category::model()->getPath($cur_leaf_id,$top_leaf->id);		

	  $criteria=new CDbCriteria;
    $criteria->condition = " 1=1 ";
		if( isset($_GET['keyword']) || !empty($_GET['keyword']) || strlen($_GET['keyword']) >0 || strlen($_GET['leaf_id'] ) > 0 ){
		  $keyword = trim($_GET['keyword']);			  
      $criteria->condition  .= ' AND title like :keyword ';  
      $criteria->params     = array(':keyword'=>"%$keyword%");      
      $opt['tpl_params']['keyword'] =& $_REQUEST['keyword'];
	  }
	  $opt['page_size'] = 15;

//    $is_include = $_GET['is_include'];

    $is_include = true;
    if( strlen( $cur_leaf_id) > 0 ){
      $mul_category =  ManyCategoryArticle::model()->findAllByAttributes( array('category_id' => $cur_leaf->id) ); 
      $all_articles = '';
      foreach( $mul_category as $_mc ){
        $all_articles .= $_mc->article_id.',';
      }

      $criteria->condition  .= ' AND find_in_set(category_id, :category_id) ';
      if( $all_articles != '' ) {
        $criteria->condition  .= ' OR find_in_set(id,:all_articles)';
        $criteria->params[':all_articles'] = $all_articles;
      }

      if( $is_include ){
        $leafs = Category::model()->findAll( array( 
          'select' => 'id, name',
          'condition'  => ' rgt <= :rgt AND lft >= :lft ',
          'params'    => array( ':rgt' => $cur_leaf->rgt, ':lft' => $cur_leaf->lft )
        ) );
        $all_leafs = '';
        foreach( $leafs as $_leaf ){
          $all_leafs .= $_leaf->id.',';
        }        
        $criteria->params[':category_id'] = $all_leafs;
      }else{
        $criteria->params[':category_id'] = $cur_leaf_id;  
      }
    }


    $_is_star =& str_replace('.html','', $_GET['is_star']);
    if( strlen($_is_star) > 0 && $_is_star == 0 ) {
      $criteria->condition .= " AND is_star = 0 ";
    }elseif( $_is_star == 1 ){
      $criteria->condition .= " AND is_star = 1 ";
    }
	  $opt['tpl_params']['is_star']  = $_is_star;

    $criteria->order        = 'create_time DESC';
	  $opt['criteria']        =  $criteria;
    $leaf_tree =& $this->getTree($top_leaf_id);
	  $opt['tpl_params']['top_leaf']  = $top_leaf;
	  $opt['tpl_params']['cur_leaf']  = $cur_leaf;
	  $opt['tpl_params']['leaf_tree'] = $leaf_tree;
//	  $opt['tpl_params']    = array( 'top_leaf' => $top_leaf, 'cur_leaf' => $cur_leaf, 'leaf_tree' => $leaf_tree );
	  parent::actionIndex($opt);
	}

	/**
	*  Move a list of article to another category
	*/
	public function actionMove() {		
		
	  $panel_ident = $_REQUEST['panel_ident'];
	  
		if( isset($_POST['category_id']) ){
			$category_id = $_POST['category_id'];
			$category = Category::model()->findByPk($category_id);
      $ids =& $_POST['ids'];
//			$ids = explode(',',$_POST['ids']);			
			foreach( $ids as $id) {				
				$at = Article::model()->findByPk($id);
				if( $at ) {									
					$at->category_id = $category->id;
					$at->save();				
				}
			}			
			echo count($ids)." record(s) are move to ";
			echo $category->name;
			exit;
		}
		
		$leafs = Category::model()->ileafs(
        array( 'id' => $_GET['top_leaf_id'],'include' => true )
	  );	  
	  
		$this->renderPartial('move', array(
			'leafs' => $leafs,
			'panel_ident' => $panel_ident,
		),false, true);
	}

  public function actionStared(){ 
    if(Yii::app()->request->isPostRequest){	 
      $ids = $_POST['ids'];            
      Article::model()->updateAll( array('is_star' => 1), " FIND_IN_SET(id,:ids) ", array( ':ids' => $ids) );      
      echo count( explode(',',$ids ) ).' content has beed Started';      
    }else{      
      $model=$this->loadModel();
      $model->is_star = 1;
      $model->save();
    }   
  }
  
  public function actionUnstared(){
    if(Yii::app()->request->isPostRequest){	   
      $ids = $_POST['ids'];                       
      Article::model()->updateAll( array('is_star' => 0), " FIND_IN_SET(id,:ids) ", array( ':ids' => $ids) );
      echo count( explode(',',$ids ) ).' content has beed Unstarted';      
    }else{
      $model=$this->loadModel();
      $model->is_star = 0;
      $model->save();  
    }
  }
  
	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
    if( !isset($_GET['rem']) ){
      $back_url = $_POST['back_url'] ? $_POST['back_url'] : rurl();
      if( stripos( $back_url,'create') == false && stripos( $back_url,'update') == false ) {
        setState('back_url', $back_url);
      }
    }

    $action =& $_GET['action'];
		$model = new Article;
		$model->category_id = $_GET['leaf_id'];
		$top_leaf_id =& $_GET['top_leaf_id'];
		$top_leaf    = Category::model()->findByPk($top_leaf_id);

		$leaf  = Category::model()->findByPk($_REQUEST['leaf_id']);
		if(isset($_POST['Article'])) {				  
		  $model->attributes=$_POST['Article'];
		  $model->update_time = $model->create_time = date("Y-m-d H:i:s");
		  $_sort_id = $leaf->first()->sort_id;
		  if( $_sort_id > 0 ){
		    $model->sort_id = $_sort_id +1;
		  }else{
		    $model->sort_id = 1;
		  }
			if($model->save()){
			  $str = Yii::t('cp','Create Success On ').Time::now();
			  Yii::app()->user->setFlash('success',$str);
			  $this->redirect(array('update','id'=>$model->id, 'action' => $action,'rem' => 0,'top_leaf_id' => $top_leaf->id ));	
			}	
		}
    $this->path = Category::model()->getPath($model->category_id,$top_leaf->id);
    $leaf_tree = $this->getTree($top_leaf->id);
    
    $_tpls = array( 276 => 'create_slideshow' );

    if(  array_key_exists( $top_leaf->id, $_tpls) ) {
      $tpl = $_tpls[$top_leaf->id];
    }else{
      $tpl = 'create';
    }

		$this->render($tpl,array( 'action' => $action, 'model'	=>	$model, 'top_leaf' => $top_leaf, 'leaf_tree' => $leaf_tree ,'leaf'	=> $leaf ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{

    if( !isset($_GET['rem']) ){
      $back_url = $_POST['back_url'] ? $_POST['back_url'] : rurl();
      if( stripos( $back_url,'create') == false && stripos( $back_url,'update') == false ) {
        setState('back_url', $back_url);
      }
    }

    $action       =& $_GET['action'];
    $top_leaf_id  =& $_GET['top_leaf_id'];
		$model=$this->loadModel(); 
    
		if(isset($_POST['Article']))
		{		  
			$model->attributes=$_POST['Article'];
			$model->update_time = date("Y-m-d H:i:s");
			if($model->save()){
        if( count( $_POST['category_article_ids'] ) > 0 ) {
          ManyCategoryArticle::model()->deleteAllByAttributes( array('article_id' => $model->id ) );
          foreach( $_POST['category_article_ids'] as $m_category_id ) {
            $_model = new ManyCategoryArticle;
            $_model->article_id = $model->id;
            $_model->category_id = $m_category_id;
            $_model->save();
          }
        }
			  $str = Yii::t('cp','Data saved success On ').Time::now();
				Yii::app()->user->setFlash('success',$str);
				$this->redirect(array('update','id'=>$model->id,'action' => $action, 'top_leaf_id' => $top_leaf_id,'rem' => 0 ));	
			}							
		}
    $leaf_tree =& $this->getTree($top_leaf_id);
    $top_leaf = Category::Model()->findByPk($top_leaf_id);
    $this->path = Category::model()->getPath($model->category_id,$top_leaf->id);

    $_tpls = array( 276 => 'update_slideshow' );
    if(  array_key_exists( $top_leaf->id, $_tpls) ) {
      $tpl = $_tpls[$top_leaf->id];
    }else{
      $tpl = 'update';
    }
  	$this->render($tpl,array( 'action' => $action, 'model'	=>	$model, 'top_leaf' => $top_leaf, 'leaf_tree' => $leaf_tree ));
	}

	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

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
				$this->_model=Article::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  public function actionBatch() {
    if(Yii::app()->request->isPostRequest) {
      $type = $_POST['type'];
		  $ids =& $_POST['ids'];
			if( count($ids) > 0 && ( $type=="删除" || $type=="delete")) {
				foreach( $ids as $id) {
				  $imodel = new $this->controllerId;
					$item = $imodel->findByPk($id);
					$item->delete();
				}
        $str = '已删除 '.count($ids).' 个用户数据 '.Time::now();
			}elseif ( count($ids) > 0 && ( $type=="复制" || $type=="copy" )) {
        foreach( $ids as $id ) {
          $at = Article::model()->findByPk($id);
          $new = new Article();							
          $new->attributes =$at->attributes;
          unset($new->attributes['id']);			
          $new->title = $new->title .' - copy';							
          $new->save();
        }
        $str = '已复制 '.count($ids).' 个用户数据 '.Time::now();
			}elseif ( count($ids) > 0 && ( $type=="重点" || $type=="star" )) {
        $count =& count($ids);
        $ids = join(',',$ids);
        Article::model()->updateAll( array('is_star' => 1), " FIND_IN_SET(id,:ids) ", array( ':ids' => $ids) );      
        $str = '已打重点 '.$count.' 个用户数据 '.Time::now();
			}elseif ( count($ids) > 0 && ( $type=="非重点" || $type=="unstar" )) {
        $count =& count($ids);
        $ids = join(',',$ids);
        Article::model()->updateAll( array('is_star' => 0), " FIND_IN_SET(id,:ids) ", array( ':ids' => $ids) );      
        $str = '已取消重点 '.$count.' 个用户数据 '.Time::now();
      }
     	Yii::app()->user->setFlash('success',$str);
      $this->redirect( rurl() );
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

  }


  public function actionBannel(){
    $leaf_id  = $_GET['leaf_id'];
    $cur_leaf = Category::Model()->findByPk($leaf_id);
    $articles = $cur_leaf->articles;
    if( $articles ) {
$s=<<<EOT
<?xml version="1.0" encoding="UTF-8"?>

<!-- slideShowTime - if set to 0, there is no autoslide -->

  <banner width = "560" height = "350"
		backgroundColor = "0xffffff"
		backgroundTransparency = "100"
		
		startWith = "1"
		barHeight = "25"
		fadeTransition = "false"
		verticalTransition = "false"
		controllerTop = "false"
		transitionSpeed = "1"
		titleX = "0"
		titleY = "0">

    <items>\n
EOT;
      foreach( $articles as $item ) {
        $s .= "\t<item>\n";
        $s .=   "\t\t<title></title>\n";
        if( $item->attachment ) {
          $image = $item->attachment->large;
          $s .=   "\t\t<path>http://local.imagine.com$image</path>\n";
        }else {
          $s .=   "\t\t<path></path>\n";
        }
        $s .=   "\t\t<url>$item->link</url>\n";
        $s .=   "\t\t<target></target>\n";
        $s .=   "\t\t<bar_color>0xcd0a10</bar_color>\n";
        $s .=   "\t\t<bar_transparency>50</bar_transparency>\n";
			  $s .=   "\t\t<slideShowTime>5</slideShowTime>\n";
        $s .= "\t</item>\n";
      }
      $s .= "</items>\n";
      $s .= '</banner>';
    }
    if( isset($s) ) {
      file_put_contents( WEBSITE_DIR.'/banner/xml/banner.xml', $s );
    }
    $this->redirect( rurl() );
  }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow',  
				'actions'=>array('bannel','innode','slideshow','ipage','news','leaf_create','leaf_update','leaf_del'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('index','view','preview','Sortarticle'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','test', 'move', 'copy','stared','unstared','batch'),
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


}
