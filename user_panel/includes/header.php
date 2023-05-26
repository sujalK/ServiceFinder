<?php  include "../helpers/initialize.php"; ?>
<?php !isset($_SESSION['user_id']) ? header("Location:../login.php") : NULL; ?>
<?php 
    if ($_SESSION['user_role'] == 'regular_user') {
        // set session to notify user that only business user can login to the user_panel
        Session::set_custom_session('invalid_login', 'You are not logged in as a business account.');
        header("Location:../login.php");
    }
?>
<?php 
    // for the logout feature
    if (isset($_GET['logout'])) {
        // unset all the session
        unset($_SESSION['user_id']);
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['account_active_status']);
        unset($_SESSION['is_verified']);
        // redirect to the login page
        header("Location:../login.php");
    } 
?>
<?php 
    // page parts
    $page_parts = explode(DIRECTORY_SEPARATOR, $_SERVER['REQUEST_URI']);
    
    // actual page
    $page = end($page_parts);

    // if user is in the users_list.php page, and not the admin, then redirect to the index.php
    if ($page === 'users_list.php') {
        if ($_SESSION['user_role'] != 'admin') {
            header("Location:index.php");
        }
    }
?>
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
    <title>Welcome | Home</title>
</head>
<body>