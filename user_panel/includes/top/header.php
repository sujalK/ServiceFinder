<section id="top-header">
        <div class="left-text">
            <h1 class="welcome-text flex-vertical">Welcome, <?php echo $_SESSION['first_name']; ?> <img src="./assets/images/celebrate.png" class="celebration-image" alt="successful login"></h1>
            <p>Here's what's happening in your Cake account today.</p>
            <div class="toggler-arrow">
                <span class="lnr lnr-arrow-left left-toggler-arrow"></span>
            </div>
        </div>
        <div class="right-admin-tools">
            <!-- <span class="lnr lnr-user"></span> -->
            <img src="assets/images/user_logo.png" class="avatar-img" alt="admin photo">
            <ul class="user-dropdown-menu hidden">
                <!-- <li class="dropdown-item"><a href="#">Profile</a></li> -->
                <li class="dropdown-item"><a href="?logout" onclick="return confirm('Are you sure?');"><span class="lnr lnr-exit"></span> Logout</a></li>
            </ul>
        </div>
    </section>