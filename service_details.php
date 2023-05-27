<?php // echo password_hash('YOUR_PASSWORD_HERE', PASSWORD_DEFAULT); ?>
<?php include "helpers/initialize.php"; ?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<?php 
// get/store the query parameter
$pattern = '/^[0-9]+$/i';
$service_id = sanitize($_GET['service_id']);

// check to see if the pattern matches
if (preg_match($pattern, $service_id)) {

    // sql to fetch the data
    $sql = "SELECT * FROM services WHERE id=". $connection->escape_string($service_id);

    // query
    $service_details = $connection->query($sql);

    // fetch the data
    $fetched_data = $service_details->fetch_assoc();

    // redirect to the homepage if the service is blocked/unverified.
    if ($fetched_data['is_verified'] == 0) header("Location:index.php");

    // var_dump($fetched_datas);

} else {
    // redirect to the homepage
    header('Location:index.php');
}


// to notify
if (
    isset($_SESSION['user_id']) && 
    $_SESSION['user_role'] == 'regular_user' && 
    isset($_GET['notify_service'])
) {

    // check if the insertion of the data into the notification table is for the first time.
    $sql = "SELECT COUNT(*) as count_no_rows FROM `notification` WHERE user_id=". $connection->escape_string($_SESSION['user_id']);
    $query = $connection->query($sql);
    $fetch_count = $query->fetch_assoc();

    // query (to insert notification)
    // clean up the data from the query string
    $notify_service_id = sanitize($_GET['notify_service']);
    $notification_sql  = "INSERT INTO `notification` (service_id, user_id) VALUES ({$connection->escape_string($notify_service_id)}, {$connection->escape_string($_SESSION['user_id'])})";

    if ($fetch_count['count_no_rows'] === '0') {
        // query the database table
        $notification_query = $connection->query($notification_sql);
    
        // if the notification was inserted successfully, then show the mssage
        if ($notification_query) $notification_message = 'The notification was sent successfully. Please check notification page to know response from the service finder.';
    } else {
        if (time_difference($_SESSION['user_id']) > 5) {
            $notification_query = $connection->query($notification_sql);
        } else {
            $notification_error = "You have recently tried to notify. You will only be allowed to re-notify after 5 minutes.";
        }
    }

}


// if there is login of a user, then perform check to see the user_role
if (isset($_SESSION['user_id'])) {
    // query to check the user is regular_user, so that the regular user can only vote and review
    $user_check_sql   = "SELECT user_role FROM users WHERE id=". $connection->escape_string($_SESSION['user_id']) . " LIMIT 1";
    $user_check_query = $connection->query($user_check_sql);
    $user_check_datas = $user_check_query->fetch_assoc();
}

// vote/reviews POST
if (
    is_post() && 
    isset($_POST['vote']) && 
    isset($_POST['review']) && 
    isset($_SESSION['user_id']) 
   // && (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'regular_user')
) {


    // vote and review text
    $vote        = sanitize($_POST['vote']);
    $review_text = sanitize($_POST['review']);

    // if there is no vote and review text given, don't post it
    if (!empty($vote) && !empty($review_text)) {
        // check to see if the same user has already posted review
        $sql          = "SELECT user_id FROM vote_and_reviews WHERE user_id = ". $connection->escape_string($_SESSION['user_id']) . " AND service_id={$service_id} LIMIT 1";
        $vote_user_id = $connection->query($sql);

        // check to see if the user is regular_user
        if ($user_check_datas['user_role'] == 'regular_user') {
            // print_r($vote_user_id->num_rows);
            // insert vote and reviews only if it does not exist for the same user
            if ($vote_user_id->num_rows == 0) {
                // vote insert query
                $sql               = "INSERT INTO vote_and_reviews (vote, review, user_id, service_id) VALUES('{$connection->escape_string($vote)}', '{$connection->escape_string($review_text)}', {$connection->escape_string($_SESSION['user_id'])}, {$connection->escape_string($service_id)})";
                $vote_insert_query = $connection->query($sql);
        
                // if the review is inserted successfully
                if ($vote_insert_query) {
                    $success_msg = "Review has been posted successfully.";
                }
        
            } else {
                $err_msg = "You have already voted this service.";
            }
        }


    } else {
        $err_msg = 'Please make sure to write a review and vote to proceed.';
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
    <link rel="stylesheet" href="./css/service_details.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/notification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" integrity="sha512-gOQQLjHRpD3/SEOtalVq50iDn4opLVup2TF8c4QPI3/NmUPNZOk2FG0ihi8oCU/qYEsw4P6nuEZT2lAG0UNYaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- for map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <title>Service finder | explore the best services/business around us</title>
    <style>

        #map-container {
            visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* align-items: center; */
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
        }

        .show-map {
            cursor: pointer;
            text-decoration: underline;
        }

        #map {
            /* max-width: 80%; */
            width: 100%;
            height: 100%;
            /* height: 500px; */
        }

        /* div: service-images */
        .service-images div {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 2.25rem 0;
        }

        /* for smaller device */
        @media screen and (max-width: 500px) {
            .service-images div {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
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

    <!-- Section: service-details -->
    <section id="service-details">
        <div class="container service-details-container">
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'regular_user'): ?>
            <!-- notify-feature -->
            <div class="top-bar p-1">
                <p class="linr"></p>
                <a href="?service_id=<?php echo $service_id; ?>&notify_service=<?php echo $service_id; ?>" onclick="return confirm('Are you sure to notify about your arrival?');" class="open-sans greenish-color underline">Notify service ?</a>
            </div>
            <?php endif; ?>
            <?php if(isset($notification_message)): ?> <p id="notify-message" class="alert-message success-message"><?php echo $notification_message; ?></p> <?php endif; ?>                
            <?php if(isset($notification_error)): ?> <p id="notify-message" class="alert-message error-message"><?php echo $notification_error; ?></p> <?php endif; ?>                
            <!-- <div class="service-title-bar">
                <p class="service-title open-sans font-3x line-h-1">Book Store Near Putalisadak</p>
            </div> -->
            <div class="service-hero-image" style="background: url('<?php echo $fetched_data['hero_image']; ?>') center center/cover;">
                <div class="service-text-container p-1">
                    <p class="service-title open-sans font-3x">
                        <?php echo $fetched_data['service_name']; ?>
                    </p>
                    <!-- <div class="short-description open-sans line-h-2">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum, amet!
                    </div> -->
                    <p class="open-sans m-1-2">Open hours - <span class="pill"><?php echo $fetched_data['open_hours']; ?></span></p>
                    <?php if ($fetched_data['is_open'] == 1): ?>
                        <p>Is Open Now ? <span class="pill"><span>Yes</span></span></p>
                    <?php endif; ?>
                    <?php if ($fetched_data['is_open'] == 0): ?>
                    <span style="background: #ec4560; color: #fff; padding: .25rem 0 .25rem 0">Is Open Now ?  <span style="color: #fff; font-weight: bold;">No</span><p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: service-description -->
    <section id="service-description">
        <div class="container service-description-container open-sans">
            <!-- badge by company -->
            <div class="badge-by-company line-h-2">
                badge
            </div>
            <!-- icons: verified, and license -->
            <div class="icons font-x open-sans font-w-600 font-2x">
                <?php if ($fetched_data['is_verified'] == 1): ?><p class="verified-badge">Verified &#x2713;</p><?php endif; ?>
                <?php if ($fetched_data['is_verified'] == 0): ?><p class="verified-badge">Unverified Service</p><?php endif; ?>
                <?php if ($fetched_data['has_certifications'] == 1): ?>
                <p class="verified-badge">
                    Certificates<span class="lnr lnr-license verified-badge"></span>
                </p>
                <?php endif; ?>
            </div><br /><br />
            <span class="line-h-2 border">Address ? <span class="pill"><?php echo $fetched_data['address']; ?></span></span> <br />
            <span class="line-h-2 border">Nearby Popular destiation ? <span class="pill"><?php echo $fetched_data['nearby_popular_destination']; ?></span></span>
            <span class="line-h-2 border">Is Open now ? <span class="pill"><?php echo $fetched_data['is_open'] == 1 ? 'Yes' : 'No'; ?></span></span>
            <!-- <p class="line-h-2 border">Is Open now ? <span class="pill">Yes</span></p> -->
            <!-- description -->
            <div class="m-2">
                <p class="line-h-2">
                    <span class="pill">Description: </span><br />
                    <?php echo $fetched_data['about_description']; ?>
                </p>
            </div>
            <div class="liner"></div>
            <!-- addresses -->
            <div class="addresses">
                <span>Primary Address: </span><span class="pill"><?php echo $fetched_data['primary_address']; ?></span>
                <span>Secondary Address: </span><span class="pill"><?php echo $fetched_data['secondary_address']; ?></span>
            </div>
            <!-- contact info -->
            <div class="contact-info m-1">
                <span>Mobile numbers: </span><span class="pill"><?php echo $fetched_data['mobile_numbers']; ?></span>
                <span>Landline numbers: </span><span class="pill"><?php echo $fetched_data['landline_numbers']; ?></span>
            </div>
            <!-- images -->
            <div class="service-images">
                <div>
                    <?php 
                        // get the images
                        $image_paths  = preg_split('/,/', $fetched_data['images']);
                        foreach($image_paths as $image) {
                            echo "<a class='fancybox' data-fancybox='gallery' href='{$image}'><img src='{$image}'></a>";
                        }
                    ?>
                </div>
            </div>
            <?php if (!empty($fetched_data['lat']) && !empty($fetched_data['lng'])): ?>
            <!-- map -->
            <span href="#" class="show-map">Show Map <i class="lnr lnr-map-marker" style="font-size: 25px;"></i></span>
            <div id="map-container">
                <div id="map"></div>
            </div>
            <?php endif; ?>

            <!-- certifications -->
            <div class="certifications">
                <h2 style="margin: 1.25rem 0;">Certifications links</h2>
                <?php 
                    // get certificats if there is any
                    $certificates = preg_split('/,/', $fetched_data['certification_images']);
                    foreach ($certificates as $cert) {
                        echo "<span style=\"display: inline-block; margin: .75rem 0;\" class='underline'><a target=\"_blank\" href=\"{$cert}\">{$cert}</a></span>&nbsp;&nbsp;<i class=\"lnr lnr-checkmark-circle\" style=\"color: green; font-weight: bold;\"></i><br />";
                    }
                ?>
                <a href=""></a>
            </div>

        </div>
    </section>
    
    <?php if (isset($_SESSION['user_id']) && isset($user_check_datas['user_role']) && $user_check_datas['user_role'] == 'regular_user'): ?>
    <?php // if($vote_user_id->num_rows == 0): ?>
    <!-- Section: review-vote -->
    <section id="review-and-vote">
        <div class="container review-and-vote-container">
            <h1 class="vote-review-title">Vote and Review</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="vote">Vote service</label>
                    <select name="vote" id="vote">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea name="review" id="review" placeholder="your review goes here"></textarea>
                </div>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </section>
    <?php // endif; ?>
    <?php endif; ?>

    <!-- section: reviews -->
    <section id="reviews">
        <div class="container reviews-container">
            <h1>Reviews</h1>
            <?php 

                // sql to query the vote of a specific user.
                $sql = "SELECT vote, review, user_id, service_id, approved, first_name, last_name FROM vote_and_reviews vr JOIN users u ON u.id = vr.user_id WHERE service_id = ". $connection->escape_string($service_id) ." AND approved = 1";
                
                // query
                $vote_and_review = $connection->query($sql);

                if ($vote_and_review->num_rows > 0):
                // iterate over review
                while ($row = $vote_and_review->fetch_assoc()):
            ?>
            <div class="review">
                <div class="img-container">
                    <img src="./images/avatar_1.webp" alt="">
                </div>
                <div class="vote-and-review">
                    <div class="user underline line-h-2">
                        <?php echo $row['first_name']. " ". substr($row['last_name'], 0, 1); ?>
                    </div>
                    <div class="vote">
                        Vote: <span class="pill"><?php echo $row['vote']; ?></span>
                    </div>
                    <div class="review line-h-2">
                        <?php echo $row['review']; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
                <p class="p-2">No reviews available.</p>
            <?php endif; ?>
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
    <script src="./js/redirect_notification.js"></script>
    <script>
        // to remove the notification alerts after a few seconds
        <?php if (!empty($notification_error) || !empty($notification_message)): ?>
            // remove the div after 3 seconds
            setTimeout(() => {
                document.querySelector("#notify-message").remove();
            }, 5000);

            <?php if(isset($notification_error)): unset($notification_error); endif; ?>
            <?php if(isset($notification_message)): unset($notification_message); endif; ?>
        <?php endif; ?>
    </script>
    <script>
        document.querySelector('.current-year').textContent = (new Date()).getFullYear();
    </script>

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- for error message -->
    <?php if(isset($err_msg)): ?>
    <script>
        // fire the sweet alert
        Swal.fire(
            'Review',
            '<?php echo $err_msg; ?>',
            'error'
        );
    <?php unset($err_msg); ?>
    </script>
    <?php endif; ?>
    
    <!-- for success message -->
    <?php if(isset($success_msg)): ?>
    <script>
        // fire the sweet alert
        Swal.fire(
            'Review',
            '<?php echo $success_msg; ?>',
            'success'
        );
    <?php unset($success_msg); ?>
    </script>
    <?php endif; ?>

    <!-- chat -->
    <script src="./utilities/chat.js"></script>
    
    <!-- fancybox -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $('.fancybox').fancybox();
    </script>

    <?php 
        if (!empty($fetched_data['lat']) && !empty($fetched_data['lng'])) {
            $latitude = $fetched_data['lat'];
            $longitude = $fetched_data['lng'];
        }
    ?>
    <!-- for map -->
    <script>
        // map instance
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // add marker wherever we are
        const marker = L.marker([0, 0]).addTo(map);

        // set latitude and longitude
        marker.setLatLng([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).update();

        // set up the view to make it a zoom
        map.setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 20);

        // add a popup
        marker.bindPopup('<strong><?php echo shorten($fetched_data['service_name'], 40); ?></strong><br /><?php echo $fetched_data['primary_address']; ?>');

        // open popup by default
        marker.openPopup();
    </script>

    <!-- for show map -->
    <script>
        document.querySelector(".show-map").addEventListener("click", () => {
            document.querySelector("#map-container").style = 'visibility: visible';
        });

        // add event listener for hide
        document.addEventListener("keydown", e => {
            if (e.key === 'Escape') {
                document.querySelector("#map-container").style = 'visibility: hidden';
            }
        });

    </script>
</body>
</html>