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

?>