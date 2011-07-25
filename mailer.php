<?php
 require("class.phpmailer.php");

   $mailer = new PHPMailer();
   $mailer->Mailer="smtp";
   $mailer->IsSMTP();
   $mailer->Host = "smtp.gmail.com";
   $mailer->SMTPSecure   = 'ssl';
   $mailer->Port       = 465; 
   $mailer->SMTPAuth = TRUE;
   $mailer->Username = 'emohuang@gmail.com';
   $mailer->Password = 'tianshixc';
   $mailer->From = 'emohuang@gmail.com';
   $mailer->FromName = 'emohuang';
   $mailer->Body = 'BODY OF EMAIL GOES HERE';
   $mailer->Subject = 'SUBJECT OF EMAIL GOES HERE';
   $mailer->AddAddress('49421240@qq.com');
   if(!$mailer->Send())
   {
      echo "Message was not sent<br/ >";
      echo "Mailer Error: " . $mailer->ErrorInfo;
   }
   else
   {
      echo "Message has been sent";
   }
exit;


$order_product  = $_POST['order_product'];
$order_num      = $_POST['order_num'];
$order_customer = $_POST['order_customer'];
$order_contact  = $_POST['order_contact'];
$order_memo     = $_POST['order_memo'];

$mail    = new PHPMailer();

$mail->IsSMTP();
//$mail->Encoding = $this->encoding;

$mail->SMTPDebug = true;
$mail->Host = 'ssl://smtp.gmail.com:465';
//$mail->Host       = "smtp.gmail.com";
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 465;                   // set the SMTP port 

$mail->Username   = "emohuang@gmail.com";  // GMAIL username
$mail->Password   = "tianshixc";            // GMAIL password

$mail->From       = "49421240@qq.com";
$mail->FromName   = "webmaster";
$mail->Subject    = iconv("UTF-8", "GB2312",  date('Y-m-d').' - 产品订购信息');
//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
$mail->AltBody    = "This is the body when user views in plain text format"; //Text Body

$mail->WordWrap   = 50; // set word wrap

date_default_timezone_set('Asia/Shanghai');
$mail->AddAddress("49421240@qq.com","First Last");
$mail->IsHTML(true); // send as HTML
$body = 'FFFFFFFFFFFF';
/*
$body  = '产品名称:'.$order_product.'<br/>';
$body .= '订购数量:'.$order_num.'<br/>';
$body .= '姓　　名:'.$order_customer.'<br/>';
$body .= '联系方式:'.$order_contact.'<br/>';
$body .= '备　　注:'.$order_memo.'<br/>';
$body .= '提交时间:'.date('Y-m-d H:i:s').'<br/>';
 */
//$body    = $mail->getFile('contents.html');

//$body    = eregi_replace("[\]",'',$body);
$body = iconv("UTF-8", "GB2312", $body);
$mail->Body = $body;
$subject = eregi_replace("[\]",'',$subject);

print_r( $mail->Send() );
exit;
if(!$mail->Send()) {
  echo 'Failed to send mail';
} else {
  echo 'Mail sent';
}

?>
