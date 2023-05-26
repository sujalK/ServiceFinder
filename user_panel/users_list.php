<?php include "./includes/header.php"; ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 

        // to activate/deactivate user is only possible by admin side
        if ($_SESSION['user_role'] === 'admin') {
            // for activate user
            if(isset($_GET['activate_id'])) {
    
                // id of user to activate their account
                $activate_id = sanitize($_GET['activate_id']);
    
                // update query
                $sql = "UPDATE users SET account_active_status = 1 WHERE id = ". $connection->escape_string($activate_id);
    
                // execute the query
                $connection->query($sql);
            }
    
            // deactivate user
            if(isset($_GET['deactivate_id'])) {
    
                $deactivte_id = sanitize($_GET['deactivate_id']);
    
                // set user to deactivate state
                $sql = "UPDATE users SET account_active_status = 0 WHERE id = ". $connection->escape_string($deactivte_id);
    
                // execute the query
                $connection->query($sql);
            }
        }

    
    ?>

    <!-- section: brand -->
    <section id="brand-" class="left-margin-container">
        <div class="container add-brand-container">
            <h1>Users List</h1>
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
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>User role</th>
                            <th>Citizenship Front</th>
                            <th>Citizenship Back</th>
                            <th>Is verified</th>
                            <th>Created At</th>
                            <th>Account active status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // counter
                            $counter = 1;

                            if ($_SESSION['user_role'] === 'admin') {
                                // to fetch all services of each users (to show to the admin)
                                $sql = "SELECT id, first_name, last_name, email, user_role, citizenship_file_front, citizenship_file_back, is_verified, created_at, account_active_status FROM users";
                            }

                            $query = $connection->query($sql);

                        ?>

                        <?php while($row = $query->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['first_name'] ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['user_role']; ?></td>
                            <td><?php echo "<img src=\"../{$row['citizenship_file_front']}\"></img>"; ?></td>
                            <td><?php echo "<img src=\"../{$row['citizenship_file_back']}\"></img>"; ?></td>
                            <td><?php echo $row['is_verified'] == 1 ? '<span style="color: #fff; background: #4caf4f; border-radius: 5px; padding: 5px; font-size: .75rem;">verified</span>' : '<span style="color: #fff; background: #ec4560; border-radius: 5px; padding: 5px; font-size: .5rem;">un-verified</span>'; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['account_active_status'] == 1 ? '<span style="color: #fff; background: #4caf4f; border-radius: 5px; padding: 5px; font-size: .75rem;">active</span>' : '<span style="color: #fff; background: #ec4560; border-radius: 5px; padding: 5px; font-size: .5rem;">in-active</span>'; ?></td>
                            <td class="options">
                                <?php if ($row['account_active_status'] == 0): ?>
                                <a href="?activate_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to activate the user?');" class="edit"><span class="lnr lnr-checkmark-circle"></span>&nbsp;Activate</a>
                                <?php endif; ?>
                                <?php if ($row['account_active_status'] == 1): ?>
                                <a href="?deactivate_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to deactivate the user?');" class="delete"><span class="lnr lnr-circle-minus"></span>&nbsp;Deactivate</a>
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
</body>
</html>