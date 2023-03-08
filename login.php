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