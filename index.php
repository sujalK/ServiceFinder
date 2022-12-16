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
            <!-- center text container -->
            <div class="center-text-container">
                <p>It's simple and smart</p>
                <h2 class="font-2">Search, Explore and Experience</h2>
                <div class="service-and-companies">
                    <div class="services">
                        <div>
                            <span class="lnr lnr-file-empty"></span>
                        </div>
                        <p>2000,036 Services</p>
                    </div>
                    <div class="companies">
                        <div>
                            <span class="lnr lnr-apartment"></span>
                        </div>
                        <p>9,914 Companies</p>
                    </div>
                </div>
            </div>
            <!-- search-form-container -->
            <form action="" method="post" class="search-form">

                <div class="form-group service-search">
                    <label for="keyword"><i class="lnr lnr-pencil"></i></label>
                    <input type="text" name="keyword" id="keyword" placeholder="Search service here...">
                </div>
                <div class="wrapper-form-group">
                    <div class="form-group">
                        <label for="place_entry"><i class="lnr lnr-location"></i></label>
                        <input type="text" name="place_entry" id="place_entry" placeholder="Place/City search...">
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
                <a href="#" class="btn-primary mt-1 register-btn-utility">Register</a>
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

</body>
</html>