<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ForgotForm extends CFormModel
{
	public $username;
	public $email;
	

	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, email', 'required'),
			// rememberMe needs to be a boolean
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
  		'username'  => Yii::t('cp','Username'),
  		'email'     => Yii::t('cp','Email'),		  
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function send_reset_pwd_mail($user)
	{
    error_reporting(E_ALL);
    //error_reporting(E_STRICT);    
    date_default_timezone_set('America/Toronto');
    //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded    
    $mail             = new PHPMailer();    
    $mail->CharSet = "UTF-8";
    $body             = "    <p>Hi $user->username: </p>";
    $body .="<p>请点击下面的链接重新设置你的密码 <p>";
    $uri  = $_SERVER['HTTP_HOST'];
    $uri .= Yii::app()->urlManager->createUrl('s/reset', array('token' => $user->token) ); 
    $body .= "<p><a href='http://".$uri."'  target='_blank' title='重置密码链接' >http://".$uri."</a>";
    $body .= "<p>如果本次密码重设请求不是由你发起，你可以安全地忽略本邮件。</p>";
    //$body .= Yii::app()->urlManager->createUrl('s/reset', array('token' => $user->token) ); 
    $body .= "</p>";
    @ $body             = eregi_replace("[\]",'',$body);    
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "mail.gmail.com"; // SMTP server
    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                               // 1 = errors and messages
                                               // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "infuzhou.webmaster@gmail.com";  // GMAIL username    
    $mail->Password   = "ihuangxc";            // GMAIL password
    
    $mail->SetFrom('infuzhou.webmaster@gmail.com', 'infuzhou');
    
    //$mail->AddReplyTo("49421240@qq.com","First Last");
    
    $mail->Subject    = "infuzhou社区重新重置用户密码";
    
    //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    
    $mail->MsgHTML($body);
    $mail->AddAddress($user->email, $user->username);
    
    if(!$mail->Send()) {
      //echo "Mailer Error: " . $mail->ErrorInfo;
      return false;
    } else {
      return true;
      //echo "Message sent!";
    }
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function forgot()
	{	  
	  
		$record = User::model()->findByAttributes( array('username'=> $this->username, 'email' => $this->email ) );
		if( $record == null ) {
		  $this->addError('username',Yii::t('cp','Incorrect username or email.' ));
		  return false;
		}else{		  		  
		  $record->token = md5( sha1($record->id).time() );
		  if( $record->save() ){
		    if( $this->send_reset_pwd_mail( $record ) ){
		      return true;
		    }else{
		      $this->addError('username','邮件服务器开小差了,请稍后再试.');
		      return false;
		    }
		  }
		  return true;
		}
	}
}
