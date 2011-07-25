<?php

class FeedbackController extends GController
{	
		
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','batch'),
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
		$model=new Feedback;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

    $panel_ident = $_REQUEST['panel_ident'];
		if(isset($_POST['Feedback']))
		{
			$model->attributes=$_POST['Feedback'];						
			$model->q_time = Time::now();
			if($model->save()){
//			  $model->addTags('tag1, tag2, tag3')->save(); 
        $str = '反馈 '.$model->id.' 已新建 '.Time::now();
	      Yii::app()->user->setFlash('success',$str);
		    $this->redirect(array('update','id'=>$model->id));    
			}
		}
    $this->render('create',array( 'model'=>$model),false,true);  
	}

	

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		$criteria=new CDbCriteria;
    $criteria->condition = ' 1=1 ';
		if( isset($_GET['keyword']) || !empty($_GET['keyword']) || strlen($_GET['keyword']) >0  ){
		  $keyword              = trim($_GET['keyword']);			  
      $criteria->condition  .= ' AND question like :keyword ';
      $criteria->params     = array(':keyword'=>"%$keyword%"); 
      $opt['tpl_params']['keyword'] = $_REQUEST['keyword'];
	  }
	  $criteria->order      = 'a_time DESC';
    $_is_answer =& str_replace('.html','',$_GET['is_answer']);
    $opt['tpl_params']['is_answer'] =& $_is_answer;
    if( $_is_answer == "1" ) {
      $criteria->condition .= " AND answer != '' ";
    }elseif( $_is_answer == "0" ) {
      $criteria->condition .= " AND answer = '' ";
    }

    $opt['criteria'] =  $criteria;
	  parent::actionIndex($opt);
	}
  
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Feedback('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Feedback']))
			$model->attributes=$_GET['Feedback'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
