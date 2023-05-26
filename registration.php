<?php require_once('./helpers/initialize.php'); ?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<?php 
    // do not allow to visit this page if the user is logged in
    if (isset($_SESSION['user_id'])) header("Location:index.php");
?>
<?php 
// check to see if the form is submitted
if (is_post()) {
    // check to see if $_FILES array has some values in it
    if (!empty($_FILES['citizenship_front']['name']) && !empty($_FILES['citizenship_back']['name'])) {

        // get user inputs for sending email to the users.
        $full_name = sanitize($_POST['first_name']) . " " . sanitize($_POST['last_name']);
        $email     = sanitize($_POST['email']);

        // generate token for both database insertion and for the email verification link
        $generate_token = get_token();

        // Business Owner
        $business_owner = new BusinessOwner($_POST, $current_date_and_time, $generate_token);
        
        // get user by email
        $user_email     = $business_owner->find_by_email($email);

        if (!$user_email) {
            // set up the front and back path
            $business_owner->citizenship_file_front = FileUploader::upload($_FILES['citizenship_front']);
            $business_owner->citizenship_file_back  = FileUploader::upload($_FILES['citizenship_back']);

            // if both the images are uploaded then
            if (!empty($business_owner->citizenship_file_front) && !empty($business_owner->citizenship_file_back)) {
                // create business owner user
                if ($business_owner->create()) {
                    // Emailer instance
                    $emailer = new Emailer (
                        getenv('SMTP_USERNAME'), 
                        'sathibhai.com', 
                        getenv('SMTP_USERNAME'), 
                        getenv('SMTP_USERNAME'), 
                        'sathibhai.com', 
                        'Please activate your account', 
                        get_register_email_text($generate_token), 
                        $email, 
                        $full_name
                    );
        
                    if ($emailer->send()) {
                        // show user creation success message
                        $success_message = 'Registration successful. Please check your email to activate your account.';
                    }
        
                } else {
                    // get errors
                    $errors = $business_owner->errors;
                }
            }

        } else {
            // user already exists
            $error_message = 'Sorry, email already exists.';
        }

    } else {
        $error_message = 'Please check all the fields before registration.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/registration.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Business Registration</title>
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
                    <a href="index.php">Home</a>
                    <!-- <a href="#">Careers</a> -->
                    <a href="contact.php">Contact</a>
                    <a href="about.php">About</a>
                </div>
                <!-- right-buttons -->
                <div class="right-buttons">
                    <!-- Only show the log in if the user is not logged in -->
                    <?php if(empty($_SESSION['user_id'])): ?>
                    <a href="login.php" class="login-btn">Log in</a>
                    <?php else: ?>
                    <div class="notification-bar">
                        <span id="notification-bell" class="lnr lnr-alarm" style="font-size: 1.25rem"></span>
                    </div>
                    <?php echo '<a href="?logout"><span class="lnr lnr-exit"></span> Logout</a>' ?>
                    <?php endif; ?>

                    <!-- only show register button if the user is not logged in -->
                    <?php if(empty($_SESSION['user_id'])): ?>
                    <a href="register.php" class="register-now-btn">Register Now</a>
                    <?php endif; ?>
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

    <?php 

        // explode file path
        $path = explode('/', '/Applications/XAMPP/xamppfiles/htdocs/service_finder/uploads/642b0ab050d407.41909243.jpg');
        $file_name = end($path);
        // remove the last element from the array
        array_pop($path);

        // directory
        $directory = end($path);
        
        // var_dump($directory);
        // var_dump($file_name);

    
    ?>

    <!-- section: main-content -->
    <section id="main-content">
        <div class="container main-content-container">
            <h1 class="register-font">Business Registration</h1>
            <!-- <img src="<?php // echo $directory . "/" . $file_name; ?>" alt=""> -->
            <span class="register-border-liner"></span>
            <p class="p-1">Let's make business grow by connecting with us.</p>
            <?php if(isset($success_message)): ?> <p class="alert-message success-message"><?php echo $success_message; ?></p> <?php endif; ?>
            <?php if(isset($error_message)): ?> <p class="alert-message error-message"><?php echo $error_message; ?></p> <?php endif; ?>
            <!-- printing errors -->
            <?php if(isset($errors)): ?>
                <?php foreach($errors as $error): ?>
                    <p class="alert-message error-message"><?php echo $error; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <form class="registration-form" action="" method="post" enctype="multipart/form-data">
                <div class="two-col-div">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="two-col-div">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password">
                    </div>
                </div>
                <div class="two-col-div">
                    <div class="form-group">
                        <label for="citizenship_front">Citizenship (Front)</label>
                        <input type="file" name="citizenship_front" id="citizenship_front">
                    </div>
                    <div class="form-group">
                        <label for="citizenship_back">Citizenship (Back)</label>
                        <input type="file" name="citizenship_back" id="citizenship_back">
                    </div>
                </div>
                <input type="submit" value="Register" name="submit">
            </form>
        </div>
    </section>
    

    <!-- footer -->
    <footer>
        <div class="container footer-container">
            <div class="copyright-text">&copy; <span class="current-year"></span>, All rights reserved.</div>
            <div class="links-group">
                <a href="about.php">About</a>
                <!-- <a href="#">Help</a>
                <a href="#">Terms</a> -->
            </div>
            <div class="footer-logo-container">
                <h1>Find<span class="logo-color">NearMe</span></h1>
            </div>
        </div>
    </footer>

    <!-- full-page-menu -->
    <section id="full-page-menu" class="hide-menu">
        <div class="container full-page-menu-container">
            <a href="index.php">Home</a>
            <!-- <a href="#">Careers</a> -->
            <a href="contact.php">Contact</a>
            <a href="about.php">About</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register Now</a>
            <div href="#" class="close-menu">&times;</div>
        </div>
    </section>

    <!-- script -->
    <script src="./js/script.js"></script>
    <script src="./js/redirect_notification.js"></script>
    <script>
        document.querySelector('.current-year').textContent = (new Date()).getFullYear();
    </script>

    <!-- chat -->
    <script src="./utilities/chat.js"></script>
</body>
</html>