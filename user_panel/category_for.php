<?php include "./includes/header.php"; ?>
<?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') header("Location:index.php"); ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 
        // for edit of the value
        if (isset($_GET['delete_id'])) {
            // category id (for deletion)
            $delete_cat_id = sanitize($_GET['delete_id']);

            // query to perform delete operation
            $sql = "DELETE FROM service_category WHERE id=". $connection->escape_string($delete_cat_id);

            // execute the query
            if ($connection->query($sql)) { 
                $del_message = 'The category has been deleted.';
            }
        }
    ?>

    <?php 
        // category array to store list of values from the database
        $cat_arr = [];
        // sql query to check if the category exists
        $sql                   = "SELECT category_name FROM service_category";
        $query_db_for_cat_name = $connection->query($sql);

        while ($row = $query_db_for_cat_name->fetch_assoc()) {
            $cat_arr[] = strtolower($row['category_name']);
        }

        // add category
        if (isset($_POST['category_name'])) {
            // get the category name
            $cat_name = sanitize($_POST['category_name']);

            if (!in_array(strtolower($cat_name), $cat_arr)) {
                $sql = "INSERT INTO service_category (category_name) VALUES ('{$connection->escape_string($cat_name)}')";

                $connection->query($sql);
            } else {
                $err = 'The category already exists.';
            }
        }
    ?>

    <!-- section: brand -->
    <section id="categorization" class="left-margin-container">
        <div class="container add-categorization-container">
            <h1>Category</h1>
            <?php if (isset($err)): ?><p style="color: red;"><?php echo $err; ?></p><?php unset($err); endif; ?>
            <?php if (isset($del_message)): ?><p style="color: red;"><?php echo $del_message; ?></p><?php unset($del_message); endif; ?>
            <form action="" method="post" class="add-categorization-form">
                <div class="form-group">
                    <label for="categorization_add">Categorization</label>
                    <input type="text" name="category_name" id="categorization_add" placeholder="Category">
                    <span class="categorization-tags">eg: electronics, gadgets shop</span>
                </div>
                <button type="submit" class="save-button" name="save"><span class="lnr lnr-checkmark-circle"></span> Done</button>
            </form>
            <!-- div: brand listings -->
            <div class="listing-table-wrapper">
                <table class="listings-table">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Category</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $counter = 1;

                            $sql = "SELECT id, category_name FROM service_category";

                            // query the database
                            $query_sql = $connection->query($sql);

                            while ($row = $query_sql->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $counter; ?>.</td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td class="options">
                                <a href="edit_category.php?edit_id=<?php echo $row['id']; ?>" class="edit"><div class="lnr lnr-pencil"></div></a>
                                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="delete"><div class="lnr lnr-trash"></div></a>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>
</body>
</html>