<?php 
// database credentials
define("DB_SERVER", "localhost");
define("DB_NAME",  "business_finder");
define("DB_USER",  "root");
define("DB_PASS",  "");

// SMTP and TinyMCE secrets live in env.local.php, which is not committed.
// Copy env.local.example.php to env.local.php and fill in the real values.
$env_local_file = __DIR__ . DIRECTORY_SEPARATOR . "env.local.php";
if (is_readable($env_local_file)) {
    require_once($env_local_file);
}

?>