<?php require_once('./helpers/initialize.php'); ?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/profile.css">
    <title>FindNearMe | About Us</title>
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
                    <a href="#">About</a>
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

    <!-- about -->
    <section id="about">
        <div class="container about-container">
            <h1>About us</h1>
            <p class="p-1 line-h-1 justify">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, harum nostrum consequatur et sint dicta voluptates modi esse tempore in tenetur officia iste soluta amet exercitationem, aperiam molestias, nihil labore ratione accusamus est quis ipsa perspiciatis. Incidunt deserunt, perferendis commodi ullam fugiat veniam cum nostrum possimus voluptatibus voluptas necessitatibus modi enim odio tempora sunt officiis eaque. Voluptatibus veniam sequi laudantium vel distinctio, architecto eos tempora voluptate pariatur corrupti nostrum ratione accusamus necessitatibus expedita tenetur debitis maxime repellat officia ad, repellendus ex. Perferendis unde pariatur, ipsa quasi architecto minus distinctio cupiditate aperiam modi quos provident natus non molestias? Autem, nobis enim?
            </p>
            <p class="p-1 line-h-1 justify">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam odio soluta in necessitatibus, beatae nulla repellat exercitationem veritatis vitae explicabo cumque quae quibusdam iusto quia a non? Nesciunt laudantium temporibus consectetur tenetur sequi obcaecati qui? Architecto optio necessitatibus itaque obcaecati delectus neque deserunt officia quos impedit similique distinctio vitae iste fuga dolorem veritatis accusamus reprehenderit, aut incidunt quisquam doloremque aliquid culpa expedita mollitia. Quos et totam ex sed eligendi. Unde amet ex ipsa tenetur aliquid quidem sunt doloremque nobis eligendi voluptates! At impedit, voluptates, ad officia ipsa quia pariatur perferendis, beatae atque delectus esse omnis animi? Inventore est ab ex.
            </p>
        </div>
    </section>

    <!-- footer -->
    <footer>
        <div class="container footer-container">
            <div class="copyright-text">&copy; <span class="current-year"></span>, All rights reserved.</div>
            <div class="links-group">
                <a href="#">About</a>
                <!-- <a href="#">Help</a> -->
                <!-- <a href="#">Terms</a> -->
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
            <a href="#">About</a>
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