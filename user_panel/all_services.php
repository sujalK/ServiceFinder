<?php include "./includes/header.php"; ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 

        // to verify/unverify service is only possible from the admin side
        if ($_SESSION['user_role'] == 'admin') {
            // for verification of the service that are listed
            if (isset($_GET['verify_id'])) {
    
                // verify_id
                $verify_id = sanitize($_GET['verify_id']);
    
                // verify sql
                $verify_sql = "UPDATE services SET is_verified = 1 WHERE id=". $connection->escape_string($verify_id);
    
                // make the service verify
                $connection->query($verify_sql);

                /* 
                    for logging purpose
                */
                // for verify log in the database table: inactive_service_log
                $log_sql = "INSERT INTO re_active_service_log (re_activated_date, service_id) VALUES(now(),{$connection->escape_string($verify_id)})";
                $connection->query($log_sql);
            }
    
            // for unverify the service that has been listed
            if (isset($_GET['unverify_id'])) {
    
                // unverify_id
                $unverify_id = sanitize($_GET['unverify_id']);
    
                // unverify sql
                $sql = "UPDATE services SET is_verified = 0 WHERE id=". $connection->escape_string($unverify_id);
    
                // make the service uverify
                $connection->query($sql);

                
                /* 
                    for logging purpose
                */
                // for unverify log in the database table: inactive_service_log
                $log_sql = "INSERT INTO inactive_service_log (inactivated_date, service_id) VALUES(now(),{$connection->escape_string($unverify_id)})";
                $connection->query($log_sql);
            }
        }


        // for open service
        if (isset($_GET['open_service'])) {
            $open_service = sanitize($_GET['open_service']);
            $sql          = "UPDATE services SET is_open = 1 WHERE id=". $connection->escape_string($open_service);
            $connection->query($sql);
        }

        // for close service
        if (isset($_GET['close_service'])) {
            $open_service = sanitize($_GET['close_service']);
            $sql          = "UPDATE services SET is_open = 0 WHERE id=". $connection->escape_string($open_service);
            $connection->query($sql);
        }

    ?>

    <!-- section: brand -->
    <section id="brand-" class="left-margin-container">
        <div class="container add-brand-container">
            <h1>Services/Businesses</h1>
            <!-- <form action="" class="add-brand-form">
                <div class="form-group">
                    <label for="add_brand">Brand name</label>
                    <input type="text" name="brand_name" id="add_brand" placeholder="brand name">
                </div>
                <button type="submit" class="save-button" name="save"><span class="lnr lnr-checkmark-circle"></span> Add brand</button>
            </form> -->
            <!-- div: brand listings -->
            <div class="listing-table-wrapper">
                <table class="listings-table">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Service name</th>
                            <th>Email</th>
                            <th>Mobile numbers</th>
                            <th>Landline numbers</th>
                            <th>Address</th>
                            <th>Primary address</th>
                            <th>Secondary address</th>
                            <th>Is verified</th>
                            <th>Open/Close</th>
                            <th>Location</th>
                            <?php if ($_SESSION['user_role'] == 'admin'): ?>
                            <th>Options</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // counter
                            $counter = 1;

                            if ($_SESSION['user_role'] === 'business_owner') {
                                // sql query to fetch own services of the business owner
                                $sql   = "SELECT is_open, s.id as service_id, `service_name`, s.is_verified as is_verified, `email`, `mobile_numbers`, `landline_numbers`, `address`, `primary_address`, `secondary_address`  FROM services s JOIN users u ON u.id = s.user_id WHERE s.user_id=". $_SESSION['user_id'];
                            } else if ($_SESSION['user_role'] === 'admin') {
                                // to fetch all services of each users (to show to the admin)
                                $sql = "SELECT is_open, s.id as service_id, `service_name`, s.is_verified as is_verified, `email`, `mobile_numbers`, `landline_numbers`, `address`, `primary_address`, `secondary_address`  FROM services s JOIN users u ON u.id = s.user_id";
                            }

                            $query = $connection->query($sql);

                        ?>

                        <?php while($row = $query->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['service_name'] ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['mobile_numbers']; ?></td>
                            <td><?php echo $row['landline_numbers']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['primary_address']; ?></td>
                            <td><?php echo $row['secondary_address']; ?></td>
                            <td><?php echo $row['is_verified'] == 1 ? '<span style="color: #fff; background: #4caf4f; border-radius: 5px; padding: 5px; font-size: .75rem;">verified</span>' : '<span style="color: #fff; background: #ec4560; border-radius: 5px; padding: 5px; font-size: .5rem;">un-verified</span>'; ?></td>
                            <td><?php echo $row['is_open'] == 1 ? '<a class=\'underline\' href="?close_service='. $row['service_id'] .'">Close ?</a>' : '<a class=\'underline\' href="?open_service='. $row['service_id'] .'">Open ?</a>'; ?></td>
                            <td>
                                <div class="loc-update" id="<?php echo $row['service_id']; ?>">
                                    <!-- <form action="">
                                        <input type="text" class="lat-value">
                                        <input type="text" class="lng-value">
                                    </form> -->
                                    <a href="#" class="underline update-location-link">Update Loc</a>
                                </div>
                            </td>
                            <td class="options">
                                <!-- Only show the options to modify service options to the admin -->
                                <?php if ($_SESSION['user_role'] == 'admin'): ?>

                                <?php if ($row['is_verified'] == 0): ?>
                                <a href="?verify_id=<?php echo $row['service_id']; ?>" onclick="return confirm('Are you sure to verify the service?');" class="edit" <?php if($_SESSION['user_role'] != 'admin') echo 'disabled'; ?>><span class="lnr lnr-checkmark-circle"></span>&nbsp;Verify</a>
                                <?php endif; ?>

                                <?php if ($row['is_verified'] == 1): ?>
                                <a href="?unverify_id=<?php echo $row['service_id']; ?>" onclick="return confirm('Are you sure to un-verify the service?');" class="delete" <?php if($_SESSION['user_role'] != 'admin') echo 'disabled'; ?>><span class="lnr lnr-circle-minus"></span>&nbsp;Unverify</a>
                                <?php endif; ?>
                                
                                <?php endif; ?>
                            </td>
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

    <!-- script for update location -->
    <script src="../js/update_location.js"></script>
</body>
</html>