<?php 

include dirname(dirname(__FILE__))."/mailer/PHPMailer/PHPMailer.php";
include dirname(dirname(__FILE__)).'/mailer/PHPMailer/Exception.php';
include dirname(dirname(__FILE__)).'/mailer/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Emailer 
{
    // email constraints
    // private $from, $from_name, $sender, $sender_email, $sender_name;
    // private $_from_address, $_from_name; // optional from_name for setFrom()
    private $mail;

    public function __construct (
        $from, 
        $from_name, 
        $sender, 
        $sender_email, 
        $sender_name,
        $subject,
        $body,
        $send_to_email,
        $receiver_name
    )
    {
        $this->mail = new PHPMailer();
        $this->set_php_mailer_config();
        $this->set_email_config($from, $from_name, $sender, $sender_email, $sender_name);
        $this->set_subject($subject);
        $this->set_body($body);
        $this->add_to_address($send_to_email, $receiver_name);
    }

    // send email: true/false
    public function send(): bool 
    {
        if($this->mail->send()) {
            return true;
        }
        return false;
    }

    // set subject
    private function set_subject ($subject) 
    {
        $this->mail->Subject = $subject;
    }

    // set email body
    private function set_body (string $body_text) 
    {
        $this->mail->Body = $body_text;
    }

    // php mailer configurations
    private function set_php_mailer_config()
    {
        $this->mail->isSMTP();
        $this->mail->Host       = 'mail.privateemail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = getenv('SMTP_USERNAME');
        $this->mail->Password   = getenv('SMTP_PASSWORD');
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port       = 465;
        $this->mail->IsHTML(true);
    }

    // set mail credentials
    private function set_email_config($from, $from_name, $sender, $sender_email, $sender_name) 
    {
        $this->mail->From     = $from;
        $this->mail->FromName = $from_name;
        $this->mail->Sender   = $sender;
        $this->mail->setFrom($sender_email, $sender_name, true);
        $this->mail->addReplyTo($sender_email, $sender_name);
    }

    // add_to_address: set up receiver address
    private function add_to_address($send_to_email, $receiver_name) 
    {
        $this->mail->addAddress($send_to_email, $receiver_name);
    }

}