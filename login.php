<?php 
    include "./helpers/initialize.php";
    /* 
        login for user roles:
        business_owner
        regular_user
    */

    // check to see if the rquest is post reequest
    if (is_post() && isset($_POST['login'])) {
        // user inputs
        $email    = sanitize($_POST['email']);
        $password = $_POST['password'];

        // check to see if both the email and password are filled in
        if (empty($email) || empty($password)) {
            Session::set_custom_session('empty_fields', 'Please make sure to fill all the fields before logging in.');
        } else {
            // get the user by email
            $user = RegularUser::find_by_email($email);

            // check to see if a user exists
            if ($user) {
                // if the password gets verified
                if ($user->verify_password($password)) {
                    // set session
                    Session::set_custom_session('user_id', $user->id);
                    Session::set_custom_session('first_name', $user->first_name);
                    Session::set_custom_session('last_name', $user->last_name);
                    Session::set_custom_session('user_role', $user->user_role);
                    Session::set_custom_session('account_active_status', $user->account_active_status);
                    Session::set_custom_session('is_verified', $user->is_verified);
    
                    // login user only if account is active
                    if ($_SESSION['is_verified'] == 1 && $_SESSION['account_active_status'] == 1) {                    
                        // redirect to the page
                        header("Location:user_panel");
                    } else {
                        // set session for error message
                        Session::set_custom_session('account_state_error', 'Please make sure your account is active and is in running state.');
                    }
                } else {
                    // invalid password (showing a generic message)
                    Session::set_custom_session('invalid_login', 'Please make sure that your login credentials are correct.');
                    // header('Location:login.php');
                }
    
            } else {
                // user not found
                Session::set_custom_session('user_not_found', 'User not found. Please make sure you\'re registered into the system.');
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
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Login | Service Finder</title>
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


    <!-- section: login -->
    <div id="login">
        <div class="container login-container">
            <!-- <div class="login-img-container">
                <img src="./images/login_img.jpg" alt="">
            </div> -->
            <div class="text-container">
                <h1 class="welcome-text">Welcome!</h1>
                <p class="p-1 login-subtext">Login into your account</p>
                <?php if(isset($_SESSION['account_state_error'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['account_state_error']; ?></p> <?php unset($_SESSION['account_state_error']); endif; ?>
                <?php if(isset($_SESSION['invalid_login'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['invalid_login']; ?></p> <?php unset($_SESSION['invalid_login']); endif; ?>
                <?php if(isset($_SESSION['user_not_found'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['user_not_found']; ?></p> <?php unset($_SESSION['user_not_found']); endif; ?>
                <?php if(isset($_SESSION['empty_fields'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['empty_fields']; ?></p> <?php unset($_SESSION['empty_fields']); endif; ?>
                
                <?php if(isset($_SESSION['user_verified'])): ?> <p class="alert-message success-message"><?php echo $_SESSION['user_verified']; unset($_SESSION['user_verified']); ?></p> <?php endif; ?>
                <?php if(isset($_SESSION['verification_failed'])): ?> <p class="alert-message error-message"><?php echo $_SESSION['verification_failed']; unset($_SESSION['verification_failed']); ?></p> <?php endif; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Your email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <input type="submit" name="login" value="Login">
                </form>
                <p>
                    Don't have an account ? <a href="#" class="signup-text">Sign Up</a>
                </p>
            </div>
        </div>
    </div>


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