<?php

class SettingController extends GController
{
	public function actionIndex()
	{	  
	  $sconfig=Sconfig::model()->find();
	  if( !$sconfig ){
	    $sconfig=new Sconfig;
	  }	  
	  if($_GET['ajax'] == 'ajax'){
	    $this->renderPartial('index',array(
  		  'sconfig' => $sconfig,
  		));
	  }else{
  	  $this->render('index',array(
  		  'sconfig' => $sconfig,
  		));  
	  }
		
	}
	public function actionSconfig() {
	  if(Yii::app()->request->isPostRequest) {
	    $_model =new Sconfig;
	    $_model->attributes=$_POST['Sconfig'];			
	    $model=Sconfig::model()->find();	    
			if( strlen(CActiveForm::validate($_model)) == 2 ) {
  	    if( !$model ){
  	      $model =new Sconfig;
  	      $model->attributes=$_POST['Sconfig'];    	    
  	      $model->save();  	      
  	    }else{
    	    Sconfig::model()->updateAll($_POST['Sconfig']);
  	    }
  	    $str = 'Data saved suc On '.date("Y-m-d H:i:s") ;
  			Yii::app()->user->setFlash('success',$str);
  	    $sconfig=Sconfig::model()->find();
	    }else{
	      $sconfig = $_model;
	      $str = 'Data saved fail! On '.date("Y-m-d H:i:s") ;
  			Yii::app()->user->setFlash('fail',$str);
	    }
	  }else{
	    $sconfig=Sconfig::model()->find();
	    if( !$sconfig ){
	      $sconfig=new Sconfig;
	    }
	  }
    $this->render('_sconfig', array('sconfig' => $sconfig ) );
	}

  public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','sconfig'),
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
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
