    <!-- section: sidebar-menu -->
    <section id="sidebar-menu">
        <div class="sidebar-container">
            <div class="sidebar-logo-container">
                <h1>Service <span class="greenish-color">Finder</span></h1>
                <!-- <img src="assets/images/logo.png" alt="2feat"> -->
            </div>
            <div class="menu-items">
                <p class="uppercase menu-title">menu</p>
                <div class="items">
                    <a href="index.php" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <div class="menu-text">Overview</div>
                    </a>
                    <a href="#" class="item product-menu">
                        <div class="menu-icon">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div class="menu-text">Services</div>
                        <div class="click-category">
                            <i class="fa fa-chevron-circle-down option-click"></i>
                        </div>
                    </a>
                    <div class="sub-menu hidden">
                        <div class="submenu-item">
                            <!-- for regular user, show their listings -->
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <a href="all_services.php">
                                <i class="fa fa-th"></i>
                                <span>All</span>
                            </a>
                            
                            <?php endif; ?>

                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'business_owner'): ?>
                            <a href="all_services.php">
                                <i class="fa fa-th"></i>
                                <span>All</span>
                            </a>
                            <a href="add_services.php">
                                <i class="fa fa-plus"></i>
                                <span>Add Services</span>
                            </a>
                            <!-- <a href="#">
                                <i class="fa fa-th-list"></i>
                                <span>Active Services</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-th-list"></i>
                                <span>Inactive Services</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                <span>Pending Approval</span>
                            </a> -->
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'regular_user'): ?>
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>My Listings</span>
                            </a>
                            <?php endif; ?>
                            <!-- <a href="#">
                                <i class="fa fa-fire"></i>
                                <span>Top Brands (Home)</span>
                            </a> -->
                            <!-- <a href="#">
                                <i class="fa fa-star"></i>
                                <span>#4 picks</span>
                            </a> -->
                            <!-- <a href="#">
                                <i class="fa fa-tags"></i>
                                <span>Styles</span>
                            </a> -->
                        </div>
                    </div>
                    <!-- <a href="#" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-th"></i>
                        </div>
                        <div class="menu-text">Freestyle tab</div>
                    </a>
                    <a href="#" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-fire"></i>
                        </div>
                        <div class="menu-text">Top category (home)</div>
                    </a> -->
                    <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="category_for.php" class="item">
                        <div class="menu-icon">
                            <span class="fa fa-database"></span>
                        </div>
                        <div class="menu-text">Category</div>
                    </a>
                    <a href="users_list.php" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="menu-text">Users Info</div>
                    </a>
                    <?php endif; ?>
                    <a href="#" class="item blog-menu" id="blog-menu">
                        <div class="menu-icon">
                            <i class="fa fa-database"></i>
                            <!-- <span class="lnr lnr-book"></span> -->
                        </div>
                        <div class="menu-text">Notification</div>
                        <div class="click-category">
                            <i class="fa fa-chevron-circle-down option-click blog-click"></i>
                        </div>
                    </a>
                    <div class="sub-menu hidden">
                        <div class="submenu-item">
                            <!-- For Admin (who can see all the nnotifications) -->
                            <a href="notifications.php">
                                <span class="lnr lnr-list"></span>
                                <span>All</span>
                            </a>
                            <!-- for user (the notification that is for them) -->
                            <!-- <a href="#">
                                <span class="lnr lnr-user"></span>
                                <span>My Notifications</span>
                            </a> -->
                            <!-- <a href="#">
                                <span class="lnr lnr-chart-bars"></span>
                                <span>Seen</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-star-empty"></span>
                                <span>Unseen</span>
                            </a> -->
                            <!-- <a href="#">
                                <span class="lnr lnr-tag"></span>
                                <span>Featured blogs</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-map-marker"></span>
                                <span>After Marketplace</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-pushpin"></span>
                                <span>Recent blogs</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-rocket"></span>
                                <span>Popular blogs</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-enter"></span>
                                <span>Quick Links</span>
                            </a> -->
                        </div>
                    </div>
                    <!-- <a href="brand.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-tag"></i>
                        </div>
                        <div class="menu-text">Brand</div>
                    </a>
                    <a href="styles.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-hand-peace"></i>
                        </div>
                        <div class="menu-text">Styles</div>
                    </a>
                    <a href="category_for.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-child"></i>
                        </div>
                        <div class="menu-text">category for</div>
                    </a>
                    <a href="marketplaces.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="menu-text">Marketplaces</div>
                    </a> -->
                    <!-- <a href="email.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="menu-text">Email</div>
                    </a> -->
                    <!-- <a href="about.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <div class="menu-text">About</div>
                    </a> -->
                </div>
            </div>
        </div> 
    </section>