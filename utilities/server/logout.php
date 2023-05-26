<?php 

// check to see if the user_id exists and the logout in GET parameter is present.
if (isset($_SESSION['user_id']) && isset($_GET['logout'])) {
    // unset the session
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['user_role']);
    unset($_SESSION['account_active_status']);
    unset($_SESSION['is_verified']);
    Session::set_custom_session('log_out_info', 'You have been logged out successfully.');
    header("Location:index.php");
}

?>