<?php 

    function connect_to_db() {
        $connection= new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        confirm_database_connection($connection);
        return $connection;
    }

    function confirm_database_connection($connection) {
        if($connection->errno) {
            $msg  = "Ooops! Something went wrong. (Database connection failed, Error: ";
            $msg .= $connection->connect_error;
            $msg .= ", ".$connection->connect_errno . ")";
            exit($msg);
        }
    }
    
    function disconnect($connection) {
        if(isset($connection)) {
            $connection->close();
        }
    }
    
    function sanitize($string) {
        return htmlspecialchars(trim($string));
    }

    function shorten($text= '', $len= '') {
        if(strlen($text) <= 10) {
            return substr($text, 0, 10);
        }
        return substr($text, 0, $len) . "...";
    }

    function blog_shorten($text) {
        if(strlen($text) <= 40) {
            return substr($text, 0, 40);
        }
        return substr($text, 0, 60) . "...";
    }

    function is_post () {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    function is_get() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    function get_token() 
    {
        return bin2hex(random_bytes(32));
    }

    function time_difference($user_id): int {
        global $connection;
        // query to fetch notified_date_time of the specific logged in user
        $sql = "SELECT notified_date_time FROM `notification` WHERE user_id=". $connection->escape_string($user_id) . " ORDER BY notified_date_time DESC LIMIT 1";
        $query_data = $connection->query($sql);
        $fetch_data = $query_data->fetch_assoc();

        // find the difference
        $datetime1 = new DateTime($fetch_data['notified_date_time']);
        $datetime2 = new DateTime();

        // intervals
        $interval = $datetime1->diff($datetime2);
        $minutes  = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;

        return $minutes;
    }

    function get_register_email_text(string $token) 
    {
        $html = <<<DEL
        Hello!<br />
        Thank you for creating account on FindNearMe. <br /><br />
        To complete your registration, click the link below <br />
        DEL;
        $html .= "<a href=\"https://saghao.com/verify.php?token=". $token ."\">Verify email address</a><br /><br />";
        $html .= "FindNearMe Team.";
        return $html;
    }

?>