<?php include "./includes/header.php"; ?>
<?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') header("Location:index.php"); ?>
<?php if(!isset($_GET['edit_id'])) header("Location:category_for.php"); ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 

        // for edit category feature

        if (isset($_GET['edit_id'])) {
            // edit category (id)
            $edit_cat_id = sanitize($_GET['edit_id']);

            // get the category data
            $cat_sql = "SELECT category_name FROM service_category WHERE id = ". $connection->escape_string($edit_cat_id);

            // execute the query
            $query_category = $connection->query($cat_sql);

            // fetch category
            $cat_data = $query_category->fetch_assoc();

        }


        // to edit
        if (isset($_POST['category_name'])) {
            // category name
            $cat_name = sanitize($_POST['category_name']);

            // sql query
            $sql = "UPDATE service_category SET category_name = '". $connection->escape_string($cat_name) . "' WHERE id = ". $connection->escape_string($edit_cat_id);

            // execute the query
            $update_query_sql = $connection->query($sql);

            // load the category page
            header("Location:category_for.php");
        }
    
    ?>


    <!-- section: brand -->
    <section id="categorization" class="left-margin-container">
        <div class="container add-categorization-container">
            <h1>Category</h1>
            <?php if (isset($update_query_sql)): ?><p style='color: green;'>Category updated successfully.</p><?php endif; ?>
            <form action="" method="post" class="add-categorization-form">
                <div class="form-group">
                    <label for="categorization_add">Categorization</label>
                    <input type="text" name="category_name" id="categorization_add" placeholder="Categorization" value="<?php echo $cat_data['category_name']; ?>">
                    <span class="categorization-tags">eg: electronics, gadgets shop</span>
                </div>
                <button type="submit" class="save-button" name="save"><span class="lnr lnr-checkmark-circle"></span> Done</button>
            </form>
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>
</body>
</html>