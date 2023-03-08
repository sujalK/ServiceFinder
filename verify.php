<?php 

include "helpers/initialize.php";

// check to see if the request is get/post
if (is_get()) {
    if (isset($_GET['token'])) {
        // verify instance
        $verify = new Verify($_GET['token']);
        
        // check to see if user is verified
        $verify->verify_user();
        
        // redirect to the register page
        header("Location: register.php");
    }
}

?>