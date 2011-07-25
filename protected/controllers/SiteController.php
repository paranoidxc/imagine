<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

  public function actionIndex_fetch() {
    $page = $_GET['page']-1;
    $limit  = 16;
    $offset = $page*16;
    $work_node =& API::node( array('ident_label' => 'work' ) );
    $list_articles = $work_node->essays( array('include' => true , 'offset' => $offset, 'limit' => $limit ) );
    foreach( $list_articles as $inst ) {
      if( $inst->gallery && $inst->leaf ) {  
        foreach( $inst->gallery->images( array( 'limit' => 1 ) ) as $t ) {
          $_url = url('site/'.( $inst->leaf ? $inst->leaf->ident_label : 'makeup') , array( 'id' => $inst->id ) );
          $arr[] = array(
                          'url'   => $_url,
                          'title' => CHtml::encode( $inst->title ),
                          'src'   => $t->getCimage('157_250')
                          );
        }
      }
    }
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($arr);
    Yii::app()->end(); 
  }

	public function actionIndex()
	{  
		$this->render('index');		
	}
  public function gallery($label='fashion') {
		$tpl = 'gallery';		
    $id = $_GET['id'];
    if( is_numeric( $_GET['id']) ) {
		  $article = Article::model()->findByPk($id);
      $tpl = 'gallery_detail';
    }elseif( strlen($_GET['id']) > 0 ){
      $article = Article::model()->findByAttributes( array('ident_label' => $id) );
      $tpl = 'gallery_detail';
    }
		$this->render($tpl,array('article' => $article,'label' => $label ),false,true);		
  }

  public function actionFashion() {
    $this->gallery('fashion');
  }

  public function actionMakeup() {
    $this->gallery('makeup');
  }

  public function actionCelebrities() { 
		$this->gallery('celebrities');
  }
 
  public function actionAdvertising() {
		$this->gallery('advertising');
  }

  public function actionFcreate() {
    $model = new Feedback;
    if( isset($_POST['Feedback']) ) {
      $model->attributes = $_POST['Feedback'];
      $model->q_time = Time::now();
      if( $model->save() ) {
        $str = '你的留言已收到,请等待回复!';
			  Yii::app()->user->setFlash('success',$str);
        $this->redirect( array('fcreate') );
      }
    }
    $this->render('fcreate',array( 'model' => $model ));
  }
  public function actionFeedback() {
    $list =& Feedback::model()->findAll( array( 'order' => 'q_time DESC' ) );
    $this->render('feedback',array('list'=> $list) );
  }
  
  public function actionAbout() {
    $id = $_GET['id'];
    $iabout     =& API::node(array('ident_label' => 'ipage'));
    $articles   =& $iabout->articles( array( 'order' => 'sort_id asc ') );

    if( is_numeric( $_GET['id']) ) {
		  $article = Article::model()->findByPk($id);
    }elseif( strlen($_GET['id']) > 0 ){
      $article = Article::model()->findByAttributes( array('ident_label' => $id) );
    }else{
      $article = $articles[0];
    }
    $this->render('about',array('articles' => $articles, 'article' => $article) );
  }

  public function actionNews() {
    $news =& API::node(array('ident_label' => 'news'));
    $tpl = 'news';
    $id = $_GET['id'];
    if( is_numeric( $_GET['id']) ) {
		  $article = Article::model()->findByPk($id);
      $tpl = 'news_detail';
    }elseif( strlen($_GET['id']) > 0 ){
      $article = Article::model()->findByAttributes( array('ident_label' => $id) );
      $tpl = 'news_detail';
    }
    list($news_list,$pagination) = $news->essays( array( 'order' => ' create_time DESC ','page_size' => 10, 'split' => 'true' ) );
    $this->render($tpl, array('news_list' => $news_list,'pagination' => $pagination,'article' => $article ),false,true );
  }


	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	
  public function actionIlogin()
	{
    if( !User()->isGuest && User::model()->findByPk(User()->id)->account_type == 1 ) {
      $this->redirect(ADMIN_URL);
      exit;
    }
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid			
			if($model->validate() && $model->login())
			  //$this->redirect( array( 'admin/category/iroot' ));
        $this->redirect(ADMIN_URL);
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
    if( !User()->isGuest && User::model()->findByPk(User()->id)->account_type == 1 ) {
      $this->redirect(ADMIN_URL);
      exit;
    }
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid			
			if($model->validate() && $model->login())
			  //$this->redirect( array( 'admin/category/iroot' ));
        $this->redirect(ADMIN_URL);
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{		
		$user = User::model()->findByPk( User()->id );
		$user->last_logout_time = Time::now();
		$user->last_ip = API::get_ip();
		$user->save();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionReset(){
	  $token = trim($_GET['token']);
	  $model = new ResetPasswordForm;	 
	  if( isset($_POST['ResetPasswordForm'] ) ){
	    $model->attributes = $_POST['ResetPasswordForm'];	    
	    if( $model->validate() && $model->reset() ){
	      echo 'reset ok';
	    }
    }else{
      $record = User::model()->findByAttributes( array('token'=> $token) );        
      $model->token = $record->token;
      if( $record == null ){
	      echo 'fuck' ;
	      exit;
	    }
    }
	  $this->render('reset', array( 'record' => $record, 'model' => $model) );	  
	}
	
	public function actionForgot() {	  
	  $model=new ForgotForm;	  
		if(isset($_POST['ForgotForm']))
		{
			$model->attributes=$_POST['ForgotForm'];			
			if($model->validate() && $model->forgot()){
			  $this->redirect( array( 'admin/category/iroot' ));
			}
		}
		$this->render('forgot',array('model'=> $model ) );
	}
	
	public function actionSignin() {  
	  $model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			  $this->redirect( array( 'site/index' ));
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('signin',array('model'=>$model));
	}
	
	public function actionSignup() {
	  
	  $model=new User;
	  if(isset($_POST['User'])) {
	    $model->attributes=$_POST['User'];
			$model->c_time = Time::now();
			if($model->save()){
			  echo " save ok ";
			  exit;
			}
	  }
	  $this->render('signup', array('model' => $model));
	}
	
	public function actionCplang(){
	  if( strlen($_REQUEST['lang']) > 0 ){
	    Yii::app()->user->setState('cplang', trim($_REQUEST['lang']));
	  }	  
	  $url = $_SERVER['HTTP_REFERER'];	  
	  header("location: $url");
	}
}
