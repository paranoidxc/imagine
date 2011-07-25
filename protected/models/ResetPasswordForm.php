<?php

class ResetPasswordForm extends CFormModel
{
	public $password;
	public $rpassword;
  public $token;
  
	public function rules()
	{
		return array(			
			array('password, rpassword,token', 'required'),		
			array('rpassword', 'compare','compareAttribute'=>'password', 'message' =>'两次密码必须一致!' )	
		);
	}
	
	public function attributeLabels()
	{
		return array(
  		'password'    => '新密码',
  		'rpassword'   =>  '请再输入一次',
		);
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function reset()
	{	
	  $record = User::model()->findByAttributes( array('token'=> $this->token) );
	  if( $record == null ){
	    $this->addError('password',Yii::t('cp','token is missing.' ));
	    return false;
	  }else {
	    $record->password = $this->password;
  	  $record->token = '';
  	  $record->save();
  	  return true;
	  }
	}
}
