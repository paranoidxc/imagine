<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $parent_id
 */
class User extends CActiveRecord
{  
  public $npassword;
  public function __get($name)
  {    
    $getter='get'.$name;
    if(method_exists($this,$getter))
      return $this->$getter();
      
    return parent::__get($name);
  }
  
  public function getIsUploadGravatar() {
    if( empty($this->avatar) ){
      return false;
    }
    return true;
  }
  public function getSourceGravatar() {
    return UPFILES_DIR.'/avatars/source_'.$this->avatar;
  }

  public function getgravatar(){    
    //return '/default_image/'.($this->id%100).'.png';
    if( empty($this->avatar) ){
      return "http://www.gravatar.com/avatar/".md5($this->email)."?s=80&d=identicon&rating=PG";
    }else{
      return UPFILES_DIR.'/avatars/'.$this->avatar;
    }
    //return rand(0, 100).'.png';
  }


	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		  array('current_login_time,last_logout_time,login_count,token,sign,avatar,account_type','default'),
			array('username, password, email,c_time', 'required'),
      array('username,password', 'match', 'pattern'=>'/^([a-zA-Z0-9_])+$/', 'message' => '字符范围26个英文字符(a-z),数字(0-9)和下划线(_)'),
			array('username','unique'),
			array('email','unique'),
			array('email','email'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('username,password,npassword', 'length', 'min'=>5),
			array('username, email', 'length', 'max'=>30),
			array('sign', 'length', 'max'=>500),
			array('password', 'length', 'max'=>32),

      array('npassword', 'match', 'pattern'=>'/^([a-zA-Z0-9_])+$/','on' => 'ad_update', 'message' => '字符范围26个英文字符(a-z),数字(0-9)和下划线(_)'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
      'articles'    => array( self::HAS_MANY, 'Article',      'user_id','order' => 'create_time DESC' ),
      'latest5'     => array( self::HAS_MANY, 'Article',      'user_id','order' => 'create_time DESC' , 'limit' => 5),
      'love_nodes'  => array( self::MANY_MANY,'Category',     'many_category_user(user_id,category_id )' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username'            => Yii::t('cp','Username'),
			'password'            => Yii::t('cp','Password'),
			'email'               => Yii::t('cp','Email'),
			'c_time'              => Yii::t('cp','Account Create Time'),
			'current_login_time'  => Yii::t('cp','Current Login Time'),
  		'current_ip'          => Yii::t('cp','Current IP'),
  		'last_ip'             => Yii::t('cp','Last IP'),
  		'last_logout_time'    => Yii::t('cp','Last Logout Time'),
  		'sign'                => Yii::t('cp','Sign'),
  		'avatar'              => Yii::t('cp','Avatar'),
  		'account_type'        => '是否管理员',
  		'npassword'           => '新密码',
			'parent_id'           => 'Parent',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
	}
}
