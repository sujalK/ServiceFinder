<?php require_once('./helpers/initialize.php'); ?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<?php 

// check to see if there is get request
if (is_get()) {

    // check to see if the query parameters are there on the GET request
    if (isset($_GET['search_service']) && isset($_GET['search_place'])) {

        // if the service and the place is present, then only proceed, else redirect to the home page
        if (!empty($_GET['search_service']) && !empty($_GET['search_place'])) {
            // query parameters
            $service         = sanitize($_GET['search_service']);
            $place_to_search = sanitize($_GET['search_place']);

            // query to fetch the required data
            $sql = <<<D
            SELECT * FROM services WHERE ( 
                MATCH(service_name) AGAINST('{$connection->escape_string($service)}' IN NATURAL LANGUAGE MODE) 
                OR 
                MATCH(about_description) AGAINST('{$connection->escape_string($service)}' IN NATURAL LANGUAGE MODE) 
                OR 
                MATCH (primary_address) AGAINST('{$connection->escape_string($place_to_search)}' IN NATURAL LANGUAGE MODE) 
                OR 
                MATCH (secondary_address) AGAINST('{$connection->escape_string($place_to_search)}' IN NATURAL LANGUAGE MODE)
                OR 
                MATCH (nearby_popular_destination) AGAINST('{$connection->escape_string($place_to_search)}' IN NATURAL LANGUAGE MODE)
            ) AND is_verified = 1
            D;

            // execute the query
            $search_query = $connection->query($sql);

            // number of rows
            $row_count = $search_query->num_rows;

        } else {
            // redirect to the home page
            header("Location:index.php");
        }
        
    }
   
} else {
    $msg = 'Invalid request';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" integrity="sha512-gOQQLjHRpD3/SEOtalVq50iDn4opLVup2TF8c4QPI3/NmUPNZOk2FG0ihi8oCU/qYEsw4P6nuEZT2lAG0UNYaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/search_results.css">
    <link rel="stylesheet" href="./css/footer.css">
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
    
    <!-- section: top-search-bar -->
    <section id="top-search-bar">
        <div class="container top-search-bar-container">
            <div class="search-bar">
                <form action="" method="GET" id="search-form">
                    <div class="form-group">
                        <input type="text" name="search_service" id="service_name" placeholder="restaurants">
                        <input type="text" name="search_place" id="place_entry" placeholder="Kathmandu">
                    </div>
                    <input type="submit" value="Find">
                </form>
            </div>
        </div>
    </section>

    <!-- section: search-results-container -->
    <div id="search-results-container">
        <div class="container search-results-container">
            <div class="top-count-display">
                <p class="ml-2 results-text">Results (<?php echo $row_count; ?>)</p>
                <?php if ($row_count === 0): ?> <p class="ml-2"> <?php echo 'Sorry, no match found.'; ?> </p> <?php endif; ?>
            </div>
            <div class="results-container">
                <?php while ($row = $search_query->fetch_assoc()): ?>           
                    <a href="service_details.php?service_id=<?php echo $row['id']; ?>" class="search-result">
                        <div class="search-img-container">
                            <img src="<?php echo $row['hero_image']; ?>" alt="">
                        </div>
                        <div class="search-text-container">
                            <p class="service-name">Book Store finder</p>
                            <p class="short-description">
                                <?php echo shorten($row['about_description'], 250) . "..." ?>
                            </p>
                            <div class="sm-grid">
                                <p class="pill">Open hours: <?php echo $row['open_hours']; ?></p>
                                <p class="pill">in operation: <span><?php echo $row['is_open'] == 1 ? 'Yes': 'No'; ?></span></p>
                            </div>
                            <div class="tags">
                                <p class="pill">Tags:</p>
                                <div class="tags-list pill">
                                    <span class="tag"><?php echo $row['tags']; ?></span>
                                </div>
                            </div>
                            <!-- <div class="notify">
                                <div href="#" class="notice-text" style="text-decoration: underline; color: #4caf4f;">notify that you want to visit ?</div>
                            </div> -->
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

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
            <a href="#">Home</a>
            <a href="#">Careers</a>
            <a href="#">Contact</a>
            <a href="#">About</a>
            <a href="#">Login</a>
            <a href="#">Register Now</a>
            <div href="#" class="close-menu">&times;</div>
        </div>
    </section>

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- validate inputs -->
    <script src="./js/validate_input.js"></script>
    
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