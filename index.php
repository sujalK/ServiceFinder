<?php require_once('./helpers/initialize.php'); ?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<?php // echo $_SESSION['user_id']; ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" integrity="sha512-gOQQLjHRpD3/SEOtalVq50iDn4opLVup2TF8c4QPI3/NmUPNZOk2FG0ihi8oCU/qYEsw4P6nuEZT2lAG0UNYaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <title>Service finder | explore the best services/business around us</title>
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
                    <!-- <div>
                        <a href="#"><span class="lnr lnr-user"></span></a>
                    </div> -->
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
            <!-- center text container -->
            <div class="center-text-container">
                <p>It's simple and smart</p>
                <h2 class="font-2">Search, Explore and Experience</h2>
                <div class="service-and-companies">
                    <!-- <div class="services">
                        <div>
                            <span class="lnr lnr-file-empty"></span>
                        </div>
                        <p>2000,036 Services</p>
                    </div> -->
                    <?php 
                        // query to count total listings
                        $sql = "SELECT COUNT(*) as total_listings FROM services";

                        // count query
                        $count_query = $connection->query($sql);

                        $count = $count_query->fetch_assoc();
                    ?>
                    <div class="companies">
                        <div>
                            <span class="lnr lnr-apartment"></span>
                        </div>

                        <!-- for single count of the listed service/business -->
                        <?php if ($count['total_listings'] == 1): ?>
                        <p><?php echo $count['total_listings']; ?> Listed service/business</p>
                        <?php endif ?>

                        <!-- for multiple count of the listed services/businesses -->
                        <?php if ($count['total_listings'] > 1): ?>
                        <p><?php echo $count['total_listings']; ?> Listed services/businesses</p>
                        <?php endif ?>

                    </div>
                </div>
            </div>
            <!-- search-form-container -->
            <form action="search_results.php" method="get" class="search-form" id="search-form">
                <div class="form-group service-search">
                    <label for="service_name"><i class="lnr lnr-pencil"></i></label>
                    <input type="text" name="search_service" id="service_name" placeholder="Search service here...">
                </div>
                <div class="wrapper-form-group">
                    <div class="form-group">
                        <label for="place_entry"><i class="lnr lnr-location"></i></label>
                        <input type="text" name="search_place" id="place_entry" placeholder="Place/City search...">
                    </div>
                    <input type="submit" value="Search" class="search-btn">
                </div>
            </form>
        </div>
    </section>

    <!-- why-choose-us -->
    <section id="why-choose-us">
        <div class="container why-choose-us-container">
            <h1>Why People choose FindNearMe ?</h1>
            <p>It's one of the fastest growing service finder service which helps hundreds of peoples in a day to locate their required place of interest.</p>
        </div>
    </section>

    <!-- why-choose-section -->
    <section id="why-choose-section">
        <div class="container why-choose-section-container">
            <!-- image-section -->
            <div class="image-section">
                <div class="img-container">
                    <img src="./images/why-choose.webp" alt="">
                </div>
            </div>
            <!-- text-section -->
            <div class="text-section">
                <h1>Pick best service you want</h1>
                <p class="mb-1">Browse through the best services around you to get better experience in the work that you're trying to do.</p>
                <a href="#" class="btn-primary">Get Started</a>
            </div>
        </div>
    </section>

    <!-- feedback -->
    <section id="feedback" class="mt-2">
        <div class="container feedback-container">
            <div class="top-container">
                <h1>Feedback about Find<span class="logo-color">NearMe</span></h1>
                <p class="feedback-top-desc">feedback occurs when outputs of a system are routed back as inputs as part of a chain of cause-and-effect that forms a circuit or loop.</p>
            </div>
            <div class="feedback-section mt-2">
                <div class="feedback-text-section">
                    <p class="review-text">
                        "FindNearMe has been a one step forward process to find the needed services on the get go.
                        It has not only assisted me in findinng the right service of my choice but also helped to manage my time in an 
                        effective way."
                    </p>
                    <div class="feedback-user-details">
                        <b>John Doe</b>
                        <p>Software engineer</p>
                        <p class="verified-badge mt-1">verified review</p>
                    </div>
                </div>
                <div class="feedback-img-section">
                    <img src="./images/feedback.webp" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- register-user -->
    <section id="register-user">
        <div class="container register-user-container">
            <div class="img-container">
                <img src="./images/register-user.webp" alt="">
            </div>
            <div class="text-div">
                <h1>Register here</h1>
                <p>Please click the buttotn below to proceed the work further</p>
                <a href="registration.php" class="btn-primary mt-1 register-btn-utility">Register</a>
            </div>
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

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- for the logout feature -->
    <script>
        <?php // $message = $_SESSION['log_out_info']; ?>
        // for logout alert
        <?php // if(isset($_SESSION['log_out_info'])): ?>
            // Swal.fire(
            //     'Logout',
            //     '<?php // echo $message; ?>',
            //     'success'
            // );
        <?php // endif; ?>
    </script>

    <!-- validate_input -->
    <script src="./js/validate_input.js"></script>

    <!-- show alert for login -->
    <script>
        <?php if(isset($_SESSION['user_role']) && !empty($_SESSION['user_role']) && $_SESSION['user_role'] == 'regular_user'): ?>

        <?php if (isset($_SESSION['regular_user_role'])): ?>
            Swal.fire(
                'Login',
                '<?php echo $_SESSION['regular_user_role']; ?>',
                'success'
            );
        
        <?php unset($_SESSION['regular_user_role']); ?>
        <?php endif; ?>

        <?php endif; ?>
    </script>

    <script>
        document.querySelector('.current-year').textContent = (new Date()).getFullYear();
    </script>

    <!-- chat -->
    <script src="./utilities/chat.js"></script>
</body>
</html>
<?php // if(isset($_SESSION['log_out_info'])) unset($_SESSION['log_out_info']); ?>