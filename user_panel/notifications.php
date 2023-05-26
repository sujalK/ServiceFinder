<?php include "./includes/header.php"; ?>

<?php 

    // for unseen
    /*
    if (isset($_GET['unseen_notification_id'])) {

        // get the notification id
        $unseen_notif_id = sanitize($_GET['unseen_notification_id']);

        // sql code to make it unseen
        $sql = "UPDATE `notification` SET seen_status = '0', seen_datetime_info = now() WHERE id= ". $connection->escape_string($unseen_notif_id);

        // query sql
        $connection->query($sql);
    }
    */

    // for seen
    if (isset($_GET['seen_notification_id'])) {

        // get the notification id
        $seen_notif_id = sanitize($_GET['seen_notification_id']);

        // sql code to make it seen
        $sql = "UPDATE `notification` SET seen_status = '1', seen_datetime_info = now() WHERE id= ". $connection->escape_string($seen_notif_id);

        // query sql
        $connection->query($sql);
    }


?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 

        

    ?>

    <!-- section: brand -->
    <section id="brand-" class="left-margin-container">
        <div class="container add-brand-container">
            <h1>Notifications</h1>
            <p>Notifications for ( our ) Service Listings</p>
            <div class="listing-table-wrapper">
                <table class="listings-table">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Service name</th>
                            <!-- <th>Username</th> -->
                            <th>Seen Status</th>
                            <th>Notified date/time</th>
                            <th>Message (from service provider/us)</th>
                            <th>Address</th>
                            <th>Mark as seen</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // counter
                            $counter = 1;

                            if ($_SESSION['user_role'] === 'business_owner') {
                                // to fetch all notifications for the specific business owner
                                $sql = "SELECT 
                                    first_name,
                                    last_name,
                                    u.id as u_id, 
                                    n.seen_status as seen_status, 
                                    n.service_id as service_id, 
                                    notified_date_time,
                                    message_by_service_provider,
                                    `service_name`,
                                    `address`,
                                    n.id as notification_id
                                FROM 
                                    services s 
                                JOIN `users` u 
                                    ON s.user_id = u.id
                                JOIN `notification` n 
                                    ON n.service_id = s.id
                                WHERE 
                                    u.id=". $connection->escape_string($_SESSION['user_id']) . " ORDER BY notified_date_time DESC";
                            } else if ($_SESSION['user_role'] === 'admin') {
                                // to fetch all notifications
                                $sql = "SELECT 
                                    first_name,
                                    last_name,
                                    u.id as u_id, 
                                    n.seen_status as seen_status, 
                                    n.service_id as service_id, 
                                    notified_date_time,
                                    message_by_service_provider,
                                    `service_name`,
                                    `address`,
                                    n.id as notification_id
                                FROM 
                                    services s 
                                JOIN `users` u 
                                    ON s.user_id = u.id
                                JOIN `notification` n 
                                    ON n.service_id = s.id";
                            }
                            
                            $query = $connection->query($sql);

                        ?>

                        <?php while($row = $query->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['service_name'] ?></td>
                            <!-- <td><?php // echo $row['first_name'] . " " . $row['last_name']; ?></td> -->
                            <td><?php echo $row['seen_status'] == '1' ? 'seen' : 'unseen'; ?></td>
                            <td><?php echo $row['notified_date_time']; ?></td>
                            <td><?php echo trim($row['message_by_service_provider']); ?></td>
                            <td><?php echo $row['address']; ?></td>

                            <?php if ($row['seen_status'] == '0'): ?>
                            <td><a href="?seen_notification_id=<?php echo $row['notification_id']; ?>" class="underline">Seen</a></td>
                            <?php else: echo '<td>-</td>'; ?>
                            <?php endif; ?>

                            <?php // if ($row['seen_status'] == '1'): ?>
                            <!-- <td><a href="?unseen_notification_id=<?php // echo $row['notification_id']; ?>" class="underline">Unseen</a></td> -->
                            <?php // endif; ?>

                            <td><a href="notification_details.php?notification_id=<?php echo $row['notification_id']; ?>" class="underline">View</a></td>
                        </tr>
                        <?php $counter++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- <a href="#" class="underline load-more">Load more</a> -->
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>
</body>
</html>