<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  private $_id;  
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
    if( strpos($this->username,'@') === false ) {
	    $record = User::model()->findByAttributes( array('username'=> $this->username) );
    }else{
	    $record = User::model()->findByAttributes( array('email'=> $this->username) );
    }
		if( $record == null ) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if ( $record->password != md5(sha1(SECRET.$this->password)) ) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
      $this->username = $record->username;
			$this->_id = $record->id;
			$this->errorCode=self::ERROR_NONE;			
			$record->current_login_time 	= Time::now();
			$record->login_count 			= $record->login_count +1;
			$record->current_ip 			= API::get_ip(); 
      $record->login_token = md5( $record->id.time().mt_rand() );
      
      $record->save(false);
			Yii::app()->user->setState('current_user',$record);
		}
		return !$this->errorCode;
		/*
		$users=array(		  
			'demo'=>'demo',
			'admin'=>'xiaochuan',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		*/
	}
	
	public function getId() {
	  return $this->_id;
	}
}
