<?php include "./includes/header.php"; ?>
    <!-- div: top-header -->
    <?php include ROOT_PAGE . "/user_panel/includes/top/header.php"; ?>

    <!-- sidebar -->
    <?php include ROOT_PAGE . "/user_panel/includes/sidebar.php"; ?>

    <?php 
        // for approve
        if (isset($_GET['approve_id'])) {
            $sql = "UPDATE vote_and_reviews SET approved = 1 WHERE id=". $connection->escape_string($_GET['approve_id']);
            $connection->query($sql);
        }

        // for unapprove
        if (isset($_GET['unapprove_id'])) {
            $sql = "UPDATE vote_and_reviews SET approved = 0 WHERE id=". $connection->escape_string($_GET['unapprove_id']);
            $connection->query($sql);
        }
    ?>

    <!-- section: brand -->
    <section id="brand-" class="left-margin-container">
        <div class="container add-brand-container">
            <h1>Votes/Reviews</h1>
            <!-- div: brand listings -->
            <div class="listing-table-wrapper">
                <table class="listings-table">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Vote (Count: 1-5)</th>
                            <th>User (Vote given by)</th>
                            <th>Service </th>
                            <th>Review</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // counter
                            $counter = 1;

                            // sql query
                            $sql   = "SELECT vr.id as id, `vote`, `review`, `first_name`, `last_name`, `service_name`, `approved` FROM vote_and_reviews vr JOIN users u ON vr.user_id = u.id JOIN services s ON vr.service_id = s.id WHERE s.user_id=". $_SESSION['user_id'];
                            $query = $connection->query($sql);
                        ?>

                        <?php while($row = $query->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['vote'] ?></td>
                            <td><?php echo $row['first_name'] . " ". $row['last_name']; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['review']; ?></td>
                            <td class="options">
                                <?php if ($row['approved'] == 0): ?>
                                <a href="?approve_id=<?php echo $row['id']; ?>" class="underline">Approve</a>
                                <?php else: ?>
                                <a href="?unapprove_id=<?php echo $row['id']; ?>" class="underline">Unapprove</a>
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