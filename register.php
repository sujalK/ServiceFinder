<?php require_once('./helpers/initialize.php'); ?>
<?php 
// post request check
if (is_post()) {
    // user form inputs
    $input_email     = sanitize($_POST['email']);
    $input_username  = sanitize($_POST['first_name']) . " " . sanitize($_POST['last_name']);
    
    // generate token for both database insertion and for the email verification link
    $generate_token = get_token();

    // RegularUser instance
    $regular_user = new RegularUser($_POST, $current_date_and_time, $generate_token);
    $user_email   = $regular_user->find_by_email($input_email);
    
    // create euser if the user does not exist
    if (!$user_email) {
        // create user
        if ($regular_user->create()) {
            // Emailer instance
            $emailer = new Emailer (
                getenv('SMTP_USERNAME'), 
                'sathibhai.com', 
                getenv('SMTP_USERNAME'), 
                getenv('SMTP_USERNAME'), 
                'sathibhai.com', 
                'Please activate your account', 
                get_register_email_text($generate_token), 
                $input_email, 
                $input_username
            );
            if ($emailer->send()) {
                // show user creation success message
                $success_message = 'Registration successful. Please check your email to activate and start using our services.';
            }
        } else {
            // get the validation errors
            $errors = $regular_user->errors;
        }
    } else {
        // show user already exists
        $error_message = 'Sorry, email already exists.';
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
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Service Finder | Register</title>
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

    <!-- section: register -->
    <section id="register">
        <div class="container register-container">
            <div class="left-register-div">
                <!-- <h1 class="p-1 main-text">Let us help you run your<br /> business.</h1> -->
                <h1 class="p-1 main-text">Let's explore the best services<br /> in the city.</h1>
                <p class="p-half sub-text">Our registration process is quick and easy.</p>
                <!-- <p class="p-half sub-text">Our registration process is quick and easy, taking no more than 10 minutes to complete.</p> -->
                <div class="bottom-review-div">
                    <p class="user-review-text">
                        I'm impressed with the results I've seen since <br />
                        starting to ue this product.<br /> I've found an easy and efficient way to get the
                        suggestions about the best services of my interest.
                    </p>
                    <div class="user-info">
                        <div class="img-container-div">
                            <img src="./images/avatar.jpg" alt="">
                        </div>
                        <div class="user-info-text">
                            <b>John Doe</b>
                            <p>Product Manager</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-register-div">
                <?php if(isset($error_message)): ?> <p class="alert-message error-message"><?php echo $error_message; ?></p> <?php endif; ?>
                <?php if(isset($success_message)): ?> <p class="alert-message success-message"><?php echo $success_message; ?></p> <?php endif; ?>
                <!-- printing errors -->
                <?php if(isset($errors)): ?>
                    <?php foreach($errors as $error): ?>
                        <p class="alert-message error-message"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_verified'])): ?> <p class="alert-message success-message"><?php echo $_SESSION['user_verified']; unset($_SESSION['user_verified']); ?></p> <?php endif; ?>
                <?php if(isset($_SESSION['verification_failed'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['verification_failed']; unset($_SESSION['verification_failed']); ?></p> <?php endif; ?>
                <h1 class="p-half">Get started</h1>
                <p class="p-half font-light">Create your account now</p>
                <form action="" method="post" class="p-1">
                    <div class="two-col-div">
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" name="first_name" id="first_name" placeholder="Alex" value="<?php // echo isset($regular_user->first_name) ? $regular_user->first_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Johnnson" value="<?php // echo isset($regular_user->last_name) ? $regular_user->last_name : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="alex_traveller@gmail.com" value="<?php // echo isset($regular_user->email) ? $regular_user->email : '' ?>">
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
                    <input type="submit" value="Sign Up">
                </form>
                <p>Have an account ? <a href="#" class="login-link">Login</a></p>
                <p class="p-3"><a href="#" class="login-link">visit here</a> for business registration</p>
            </div>
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