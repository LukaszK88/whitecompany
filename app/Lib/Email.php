<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/10/2016
 * Time: 12:28
 */
namespace Whitecompany\Lib;


use PHPMailer as PHPMailer;


class Email{

    public static function sendEmail($to,$subject,$body)
   {


           $mail = new PHPMailer;


//$mail->SMTPDebug = 3;                               // Enable verbose debug output

           $mail->isSMTP();                                      // Set mailer to use SMTP
           $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
           $mail->SMTPAuth = true;                               // Enable SMTP authentication
           $mail->Username = 'lukaskowalpl@yahoo.co.uk';                 // SMTP username
           $mail->Password = getenv('EMAIL_PASS');                           // SMTP password
           $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
           $mail->Port = 465;                                    // TCP port to connect to

           $mail->setFrom('lukaskowalpl@yahoo.co.uk ');
           $mail->addAddress($to);     // Add a recipient
           $mail->addAddress('');               // Name is optional
           $mail->addReplyTo('info@example.com', 'Information');
           $mail->addCC('');
           $mail->addBCC('');

           $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
           $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
           $mail->isHTML(true);                                  // Set email format to HTML

           $mail->Subject = $subject;
           $mail->Body = $body;
           $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
           
        if($mail->send()){
            echo 'sent';
        }else{
            echo 'not sent';
            //var_dump($mail->ErrorInfo);
            //die();
        }
   }

}
