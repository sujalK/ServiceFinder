<?php 
// mailer files
require "mailer/PHPMailer/PHPMailer.php";
require 'mailer/PHPMailer/Exception.php';
require 'mailer/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// user input
if (isset($_POST['submit'])) {

    $sender_name  = $_POST['your_name'];
    $sender_email = $_POST['your_email'];
    $message      = $_POST['message'];

    // check to see if the inputs is not empty
    if ($sender_name != '' && $sender_email != '' && $message != '') {
        
        // PHP Mailer
        $mail= new PHPMailer();

        try {
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'mail.privateemail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = getenv('SMTP_USERNAME');                     // SMTP username
            $mail->Password   = getenv('SMTP_PASSWORD');                               // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
            $mail->Port       = 465;

            $mail->IsHTML(true);
            $mail->From=getenv('SMTP_USERNAME'); // sending from contact page
            $mail->FromName='sathibhai.com';
            $mail->Sender=getenv('SMTP_USERNAME');
            $mail->AddReplyTo($sender_email, $sender_name);
            // set reply to
            $mail->setFrom('sathibhai.com', 'sathibhai.com', false);
            $mail->Subject = 'Contact';

            $html= "Full Name: {$sender_name} <br /> Email: {$sender_email} <br /> Message: {$message}";

            $mail->Body = $html;

            // send contact info to sathibhai.com
            $mail->AddAddress(getenv('SMTP_USERNAME'));

            if($mail->send()) {
                $msg= "Your query has been submitted.";
            } else {
                $msg= "Something wrong happened! please try again.";
            }
        } catch (Exception $e) {
            
        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/contact.css">
    <title>Service Finder | Contact Us</title>
</head>
<body>
    
    <!-- Top section -->
    <section id="top-section">
        <div class="container top-section-container">
            <!-- top nav -->
            <div class="top-nav">
                <!-- logo-container -->
                <div class="logo-container">
                    <h1>Find<span class="logo-color">NearMe</span></h1>
                </div>
                <!-- center-navigation -->
                <div class="center-navigation">
                    <a href="#">Home</a>
                    <a href="#">Careers</a>
                    <a href="#">Contact</a>
                    <a href="#">About</a>
                </div>
                <!-- right-buttons -->
                <div class="right-buttons">
                    <a href="#" class="login-btn">Log in</a>
                    <a href="#" class="register-now-btn">Register Now</a>
                </div>
                <!-- hamburger menu -->
                <div class="hamburger-menu">
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                    <div class="menu-line"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact-us">
        <div class="container contact-us-container">
            <h1 class="contact-us-title">
                Love to hear from you, <br />
                Get in touch. 👋
            </h1>
            <?php if (isset($msg)): ?>
            <h2 class="mail-msg"><?php echo $msg; ?></h2>
            <?php endif; ?>
            <!-- contact-us form -->
            <form action="contact.php" method="POST" class="contact-us-form">
                <div class="two-col-form-group">
                    <div class="form-group">
                        <label for="your_name">Your name</label>
                        <input type="text" name="your_name" id="your_name" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="your_email">Your email</label>
                        <input type="email" name="your_email" id="your_email" placeholder="doejohn2002@gmail.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" placeholder="let us know about your inquiries."></textarea>
                </div>
                <button type="submit" name="submit" value="submit" class="contact-send-button">Just Send &nearr;</button>
            </form>
        </div>
    </section>

    <!-- footer -->
    <footer>
        <div class="container footer-container">
            <div class="copyright-text">&copy; 2022, All rights reserved.</div>
            <div class="links-group">
                <a href="#">About</a>
                <a href="#">Help</a>
                <a href="#">Terms</a>
            </div>
            <div class="footer-logo-container">
                <h1>Find<span class="logo-color">NearMe</span></h1>
            </div>
        </div>
    </footer>

    <!-- full-page-menu -->
    <section id="full-page-menu" class="hide-menu">
        <div class="container full-page-menu-container">
            <a href="#">Home</a>
            <a href="#">Careers</a>
            <a href="#">Contact</a>
            <a href="#">About</a>
            <a href="#">Login</a>
            <a href="#">Register Now</a>
            <div href="#" class="close-menu">&times;</div>
        </div>
    </section>

    <!-- script -->
    <script src="./js/script.js"></script>
</body>
</html>