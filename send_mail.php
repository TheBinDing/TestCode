<?php
    /**
    * Simple example script using PHPMailer with exceptions enabled
    * @package phpmailer
    * @version $Id$
    */

    date_default_timezone_set('Asia/Bangkok');

    require 'PHPMailer_5.2.4/class.phpmailer.php';

    //send e-mail to user
    $detail = 'ทดสอบการส่ง Email';
    $subject = 'ทดสอบการส่ง Email';
    $mail_from = "apichat.si@thaipolycons.co.th";
    $mail_name = "apichat";
    $msg = sendMail($detail,$subject,$mail_from,$mail_name,1);

    function sendMail($detail,$subject,$from,$name,$send){
        $mail = new PHPMailer();
        $mail->Body = $detail;
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();// Set mailer to use SMTP
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        // $mail->Host = "192.168.1.78"; // SMTP server
        $mail->Host = "mail.csloxinfo.com"; // SMTP server
        // $mail->Host = "smtp.gmail.com"; // Gmail
        // $mail->Host = "smtp.live.com"; // hotmail.com
        // $mail->Port = 25; // พอร์ท 25, 465 or 587
        // $mypath = 'img/excel.png';
        // $mypath_name = 'รูปตัวอย่าง';
        $mail->Username = "apichat.si@thaipolycons.co.th"; // SMTP username
        $mail->Password = "tpolypassword"; // SMTP password
        //from
        $mail->SetFrom($from, $name);   
        $mail->IsHTML(true);
        //send mail
         if($send == 1){
            $mail->AddAddress("apichat.si@thaipolycons.co.th", "apichat");
         }else{
            $mail->AddAddress($send);
         }
        
        //$mail->AddReplyTo("email@yourdomain.com", "yourname");
        $mail->Subject = $subject;      
        
        if(!$mail->send()){
            $msg = iconv('UTF-8', 'TIS-620', 'ไม่สามารถส่ง mail ได้ค่ะ');
            $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $msg = iconv('UTF-8', 'TIS-620', 'ส่ง mail แจ้งเรียบร้อยแล้วค่ะ');
        }
        return $msg;
    }
?>