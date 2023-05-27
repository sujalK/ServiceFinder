<?php include "./includes/header.php"; ?>

    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <!-- section: overview -->
    <section id="overview" class="left-margin-container">
        <div class="container overview-container">
            <div class="items">
                <?php 
                    /* 
                        To fetch the Active services
                    */

                    // sql to fetch all of the active services count (for admin)
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                        // $sql = "SELECT COUNT(*) as active_services FROM services WHERE service_active_status = 1";
                        $sql = "SELECT COUNT(*) as active_services FROM services WHERE is_verified = 1 AND service_active_status = 1";
                    } else {
                        // $sql = "SELECT COUNT(*) as active_services FROM services WHERE service_active_status = 1 AND user_id = ". $connection->escape_string($_SESSION['user_id']);
                        $sql = "SELECT COUNT(*) as active_services FROM services WHERE (is_verified = 1 AND service_active_status = 1) AND user_id = ". $connection->escape_string($_SESSION['user_id']);
                    }

                    $active_accounts = $connection->query($sql);
                    $fetch_active    = $active_accounts->fetch_assoc();
                ?>
                <div class="item">
                    <div class="left-icon">
                        <span class="lnr lnr-apartment greenish-color"></span>
                        <span class="bold-text"><?php echo $fetch_active['active_services']; ?></span>
                    </div>
                    <div class="right-text">
                        <p>Active Services</p>
                        <a href="all_services.php">List services &nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php 
                    /* 
                        To fetch the Inactive services
                    */

                    // to fetch all inactive services (for admin)
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                        $sql = "SELECT COUNT(*) as inactive_services FROM services WHERE service_active_status = 0";
                    } else {
                        // for business_owner
                        $sql = "SELECT COUNT(*) as inactive_services FROM services WHERE service_active_status = 0 AND user_id = ". $connection->escape_string($_SESSION['user_id']);
                    }

                    $inactive_accounts = $connection->query($sql);
                    $fetch_inactive    = $inactive_accounts->fetch_assoc();
                ?>
                <div class="item">
                    <div class="left-icon">
                        <span class="lnr lnr-book redish-color"></span>
                        <span class="bold-text"><?php echo $fetch_inactive['inactive_services']; ?></span>
                    </div>
                    <div class="right-text">
                        <p>Inactive Services</p>
                        <a href="all_services.php">List services &nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php 
                    /* 
                        To fetch Pending (Services) Approvals 
                    */

                    // to fetch all of the pending services for admin
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                        $sql = "SELECT COUNT(*) as pending_approval FROM services WHERE is_verified = 0";
                    } else {
                        // for business_owner
                        $sql = "SELECT COUNT(*) as pending_approval FROM services WHERE is_verified = 0 AND user_id=". $connection->escape_string($_SESSION['user_id']);
                    }

                    $pending_accounts = $connection->query($sql);
                    $fetch_pending    = $pending_accounts->fetch_assoc();
                ?>
                <div class="item">
                    <div class="left-icon">
                        <span class="lnr lnr-cog orange-color"></span>
                        <span class="bold-text"><?php echo $fetch_pending['pending_approval']; ?></span>
                    </div>
                    <div class="right-text">
                        <p>Pending Approval (Services)</p>
                        <a href="all_services.php">List services &nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <!-- show Inactive user accounts only to the Admin (Owner of the website) -->
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <?php 
                    // sql to fetch inactive accounts count
                    $inactive_accounts_sql   = "SELECT COUNT(*) as inactive_user_account FROM users WHERE account_active_status = 0";    
                    $inactive_acc            = $connection->query($inactive_accounts_sql);
                    $fetch_inactive_accounts = $inactive_acc->fetch_assoc();
                ?>
                <div class="item">
                    <div class="left-icon">
                        <span class="lnr lnr-users bluish-color"></span>
                        <span class="bold-text"><?php echo $fetch_inactive_accounts['inactive_user_account']; ?></span>
                    </div>
                    <div class="right-text">
                        <p>Inactive Accounts</p>
                        <a href="users_list.php">List accounts &nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- chart -->
            <?php // if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'business_owner'): ?>
                <div id="chart">
                    <div id="top_x_div" style="width: 900px; height: 500px; margin-top: 20px;"></div>
                </div>
            <?php // endif; ?>
        </div>
    </section>

    <!-- section: email-reminder -->
    <!-- <section id="email-reminder" class="left-margin-container">
        <div class="container email-reminder-container">
            <div class="top-div">
                <p>Reminder emails ?</p>
                <p>It's simpler than ever!</p>
            </div>
            <div class="bottom-div">
                <div class="left-div">
                    <div class="icon-div">
                        <span class="lnr lnr-envelope"></span>
                    </div>
                    <div class="text-div">
                        <strong>Remind the customers to explore the newly added products ?</strong>
                        <p>Email the customer for better engagement.</p>
                    </div>
                </div>
                <div class="right-div">
                    <a href="#" class="email-reminder-link">
                        Open<span class="lnr lnr-chevron-right-circle"></span>
                    </a>
                </div>
            </div>
        </div>
    </section> -->


    <!-- Charts only for the business owner -->
    <?php // if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'business_owner'): ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Items', 'Count'],
          ["Active Services", <?php echo $fetch_active['active_services']; ?>],
          ["Inactive Services", <?php echo $fetch_inactive['inactive_services']; ?>],
          ["Pending Approval", <?php echo $fetch_pending['pending_approval']; ?>],
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          ["Inactive Accounts", <?php echo $fetch_inactive_accounts['inactive_user_account']; ?>],
          <?php endif; ?>
        ]);

        var options = {
          title: 'Chess opening moves',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'Stats',
                   subtitle: 'By counts' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Counts'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };

        window.onresize = drawStuff();
    </script>
    <?php // endif; ?>

<?php include "./includes/footer.php"; ?>