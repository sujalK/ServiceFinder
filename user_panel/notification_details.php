<?php include "./includes/header.php"; ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 

        // check to see if the notification id is set
        if (isset($_GET['notification_id'])) {

            // notification id
            $notification_id = sanitize($_GET['notification_id']);

            // sql code to fetch message
            $sql = "SELECT `message_by_service_provider` FROM `notification` WHERE id=". $connection->escape_string($notification_id);

            // query the sql
            $query_result = $connection->query($sql);

            $message_from_db = $query_result->fetch_assoc();

            $actual_message = $message_from_db['message_by_service_provider'];

        }

        // check to see if the request is POST request
        if (isset($_POST['submit'])) {
            // message text
            $message_text    = sanitize($_POST['message']);

            if (!empty($message_text)) {
                // update query
                $sql = "UPDATE `notification` SET message_by_service_provider = '". $connection->escape_string($message_text) ."' WHERE id = ". $connection->escape_string($notification_id);
            
                // query
                $update_query = $connection->query($sql);
                
                // success message
                if ($update_query) $success_msg = 'Update to the notification text has been done.';
            }
        }
    
    ?>

    <!-- Section: message-update -->
    <section id="message-update" class="left-margin-container">
        <div class="container message-update-container">
            <form action="" method="POST">
                <?php 
                    if (isset($success_msg)) {
                        echo "<p style='color: green;'>" . $success_msg . "</p>"; 
                        unset($success_msg);
                    }
                ?>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" placeholder="enter your message that you want to notify to customer."><?php if(isset($actual_message)): echo trim($actual_message); endif; ?></textarea>
                </div><br>
                <input type="submit" name="submit" value="Add notification text">
            </form>
        </div>
    </section>

    <!-- Toggler class -->
    <script src="./assets/js/classes/Toggle.js"></script>

    <!-- script -->
    <script src="./assets/js/script.js"></script>
</body>
</html>