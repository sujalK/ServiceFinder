<?php include "helpers/initialize.php"; ?>
<?php 
    // if there is no logged-in user
    if (!isset($_SESSION['user_role'])) header("Location:index.php");

    // if the logged in user account is deactive
    if ($_SESSION['account_active_status'] == 0) header("Location:index.php");

    // redirect to the home page if the user role is other than regular_user
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'regular_user') {
        header("Location:index.php"); 
    }
?>

<?php 

    // to dismiss notification
    if (
        isset($_SESSION['user_id']) && 
        $_SESSION['user_role'] == 'regular_user' && 
        isset($_GET['dismiss_id'])
    ) {

        // notification id
        $notification_id = sanitize($_GET['dismiss_id']);

        // sql query to update the data
        $sql = "UPDATE `notification` SET show_hide = 0 WHERE id = " . $connection->escape_string($notification_id) . " AND user_id = ". $connection->escape_string((int) $_SESSION['user_id']);

        // execute the query
        $connection->query($sql);
    }

?>
<?php include ROOT_PAGE . "/utilities/server/logout.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/notification.css">
    <title>Service Finder | Notifications</title>
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
                        <div class="notifications">
                            <div class="notification">
                                
                            </div>
                        </div>
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

    <!-- section: notification -->
    <section id="notification">
        <div class="container notification-container">
            <div class="notifications">
                <h1 class="py-1">Notifications</h1>
                <!-- notification -->
                <?php 

                    // if ($_SESSION['user_role'] == 'regular_user') {
                        $sql = "SELECT 
                        n.id as notification_id,
                        `seen_status`, 
                        `service_name`, 
                        `message_by_service_provider`, 
                        `seen_datetime_info`,
                        `notified_date_time` 
                            FROM `notification` AS n 
                        JOIN services AS s 
                            ON n.service_id=s.id 
                        JOIN users AS u 
                            ON u.id = s.user_id 
                        WHERE 
                        n.user_id=". $connection->escape_string($_SESSION['user_id']) . " AND show_hide = 1";
                    //} else {
                        // query to fetch notification of the logged in user
                    //     $sql = "SELECT 
                    //     n.id as notification_id,
                    //     `seen_status`, 
                    //     `service_name`, 
                    //     `message_by_service_provider`, 
                    //     `seen_datetime_info`,
                    //     `notified_date_time` 
                    //         FROM `notification` AS n 
                    //     JOIN services AS s 
                    //         ON n.service_id=s.id 
                    //     JOIN users AS u 
                    //         ON u.id = s.user_id";
                    // }

                    // query the sql
                    $notification_query = $connection->query($sql);
                    
                    // if there is rows then loop
                    if ($notification_query->num_rows > 0):
                    // iterate over the notifications
                    while ($row = $notification_query->fetch_assoc()):
                ?>
                <div class="item">
                    <div class="left-div">
                        <div class="bell-icon">
                            <span id="notification-bell" class="lnr lnr-alarm"></span>
                        </div>
                        <div class="text-section">
                            <p>Service name: <?php echo $row['service_name']; ?></p>
                            <p>Sent at: <span class="pill"><?php echo $row['notified_date_time']; ?></span></p>
                            <?php 
                                // show seen status as well as time when the user has seen the notification
                                if ($row['seen_status'] === '1' && $row['seen_datetime_info'] !== 'NULL'):
                            ?>
                            <p>Message - <?php echo $row['message_by_service_provider'] == '' ? '[...]' :$row['message_by_service_provider']  ?></p>
                            <p><span class="pill"><?php echo $row['seen_status'] == '0' ? 'Unseen' : 'seen'; ?></span>
                            <!-- <span class="pill">Seen date time:<?php // echo $row['seen_datetime_info']; ?></span></p> -->
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="hide-btn">
                        <a href="?dismiss_id=<?php echo $row['notification_id']; ?>" class="underline">Dismiss</a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <?php echo '<span class="pill">No notifications</span>'; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- footer -->
    <footer>
        <div class="container footer-container">
            <div class="copyright-text">&copy; 2022, All rights reserved.</div>
            <div class="links-group">
                <a href="about.php">About</a>
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

    <!-- redirect script -->
    <script src="./js/redirect_notification.js"></script>

    <!-- chat -->
    <script src="./utilities/chat.js"></script>
</body>
</html>