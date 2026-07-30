<?php require_once dirname(__DIR__) . '/helpers/credentials.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <link rel="stylesheet" href="./assets/styles/style.css">
    <?php // TinyMCE API key goes here, supplied by the TINYMCE_API_KEY environment variable ?>
    <script src="https://cdn.tiny.cloud/1/<?= htmlspecialchars(getenv('TINYMCE_API_KEY') ?: '', ENT_QUOTES, 'UTF-8') ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Admin Panel | About</title>
</head>
<body>
    
    <!-- div: top-header -->
    <section id="top-header">
        <div class="left-text">
            <h1 class="welcome-text flex-vertical">Welcome, Admin <img src="./assets/images/celebrate.png" class="celebration-image" alt="successful login"></h1>
            <p class="underline section-text">About section</p>
            <div class="toggler-arrow">
                <span class="lnr lnr-arrow-left left-toggler-arrow"></span>
            </div>
        </div>
        <div class="right-admin-tools">
            <img src="assets/images/avatar.jpg" class="avatar-img" alt="admin photo">
            <ul class="user-dropdown-menu hidden">
                <li class="dropdown-item"><a href="#">Profile</a></li>
                <li class="dropdown-item"><a href="#">Logout</a></li>
            </ul>
        </div>
    </section>

    <!-- section: sidebar-menu -->
    <section id="sidebar-menu">
        <div class="sidebar-container">
            <div class="sidebar-logo-container">
                <img src="assets/images/logo.png" alt="2feat">
            </div>
            <div class="menu-items">
                <p class="uppercase menu-title">menu</p>
                <div class="items">
                    <a href="index.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <div class="menu-text">Overview</div>
                    </a>
                    <a href="#" class="item product-menu">
                        <div class="menu-icon">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div class="menu-text">Product</div>
                        <div class="click-category">
                            <i class="fa fa-chevron-circle-down option-click"></i>
                        </div>
                    </a>
                    <div class="sub-menu hidden">
                        <div class="submenu-item">
                            <a href="add_product.html">
                                <i class="fa fa-plus"></i>
                                <span>Add Product</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-th-list"></i>
                                <span>All Listings</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                <span>Category</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>Freestyle tab</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-fire"></i>
                                <span>Top Brands (Home)</span>
                            </a>
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
                    <a href="#" class="item blog-menu" id="blog-menu">
                        <div class="menu-icon">
                            <i class="fa fa-database"></i>
                            <!-- <span class="lnr lnr-book"></span> -->
                        </div>
                        <div class="menu-text">Blog</div>
                        <div class="click-category">
                            <i class="fa fa-chevron-circle-down option-click blog-click"></i>
                        </div>
                    </a>
                    <div class="sub-menu hidden">
                        <div class="submenu-item">
                            <a href="#">
                                <span class="lnr lnr-plus-circle"></span>
                                <span>Add blog</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-list"></span>
                                <span>All Listings</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-chart-bars"></span>
                                <span>Category</span>
                            </a>
                            <a href="#">
                                <!-- <i class="fa fa-star"></i> -->
                                <span class="lnr lnr-star-empty"></span>
                                <span>#3 picks</span>
                            </a>
                            <a href="#">
                                <span class="lnr lnr-user"></span>
                                <span>Editor's pick</span>
                            </a>
                            <a href="#">
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
                            </a>
                        </div>
                    </div>
                    <a href="brand.html" class="item">
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
                    </a>
                    <a href="email.html" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="menu-text">Email</div>
                    </a>
                    <a href="#" class="item">
                        <div class="menu-icon">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <div class="menu-text">About</div>
                    </a>
                </div>
            </div>
        </div> 
    </section>

    <!-- section: about-section -->
    <section id="about-section" class="left-margin-container">
        <div class="container about-section-container">
            <h1>About</h1>
            <form action="" class="about-section-form">
                <div class="top-stories">
                    <!-- story: left-section -->
                    <div class="left-story-section">
                        <div class="form-group">
                            <label for="our-story-heading">Our story heading text</label>
                            <input type="text" name="our_story_heading" id="our-story-heading">
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short description</label>
                            <input type="text" name="short_description" id="short_description">
                            <span class="text-sm">Max. 50 words</span>
                        </div>
                    </div>
                    <!-- story: right-section -->
                    <div class="right-story-section">
                        <div class="form-section">
                            <div class="dotted-bottom">
                                <div class="form-group">
                                    <label>(Each) Story title</label>
                                    <input type="text" name="each_story_title" class="each_story_title">
                                </div>
                                <div class="form-group">
                                    <label>(Each) Story subtitle</label>
                                    <input type="text" name="each_story_subtitle" class="each_story_subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="add-more-story"><div class="fa fa-plus"></div></div>
                    </div>
                </div>
                <!-- our-mission -->
                <div class="our-mission">
                    <div class="form-group">
                        <label for="our-mission-text">Our mission text</label>
                        <textarea name="our_mission" id="our-mission-text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="our-mission-image">Our mission image</label>
                        <input type="file" name="our_mission_file">
                    </div>
                </div>
                <!-- our vision -->
                <div class="our-vision">
                    <div class="form-group">
                        <label for="our-vision-text">Our vision text</label>
                        <textarea name="our_vision_text" id="our-vision-text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="our-vision-image">Our vision image</label>
                        <input type="file" name="our_vision_text" id="our-vision-image">
                    </div>
                </div>
                <button type="submit" class="save-button" name="save"><span class="lnr lnr-checkmark-circle"></span> Save</button>
            </form>
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>

    <!-- for tiny mce wysiwyg editor -->
    <script>
        // initialization of Tiny MCE editor
        tinymce.init({
            selector: 'textarea',
            plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
</body>
</html>