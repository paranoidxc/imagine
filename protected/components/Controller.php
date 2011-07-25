<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $controllerId;
	public $actionId;
	
	public $signoutUrl;
	public $signinUrl;
	public $signupUrl;
  public $_pageTitle;	
  public $iuser;
  public $_keyword;
  public $_desc;

	public function init() {

//   Yii::app()->theme = 'forum';
//   Yii::app()->name = 'ifuckforum';

	  $this->isconfig=Sconfig::model()->find();	  	  
	  $this->controllerId =  ucfirst($this->getId() );
    
	  if( Yii::app()->user->getState('cplang') ){
	    Yii::app()->language = Yii::app()->user->getState('cplang');
	  }	  
	  //Yii::app()->language = 'en_us';
	  //print_r( Yii::app()->language);
	  
    if( Yii::app()->user->getState('scategory') ){         
      //print_r(Yii::app()->user->getState('scategory'));
    }else{
      $_scategory = Category::model()->findAll(array('select'=> 'id,name'));
      $__scategory = array();
      foreach( $_scategory as $icat ) {
        $__scategory[$icat['id']]['id'] =   $icat['name'];
      }
      unset($_scategory);
      Yii::app()->user->setState('scategory',$__scategory);            
    }
	  if( $this->isconfig && $this->isconfig->is_oops ) {
	    //echo "oops";
	    //exit;
	  }

    if( !Yii::app()->user->isGuest ) {
      $this->iuser = User::model()->findByPk( Yii::app()->user->id );
    }

	}
	
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	public $location;
	public $page_navigation;
	public $isconfig;	
	public $scategory;
}
