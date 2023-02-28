<?php 
ob_start();
    
// this will send cookies only on HTTPS connection
// ini_set('session.cookie_secure', '1');

ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');

// File Path
define("DS", DIRECTORY_SEPARATOR);
define("ROOT_PAGE", dirname(dirname(__FILE__)));

require_once("credentials.php");
require_once("functions.php");

// Autoloading classes
spl_autoload_register(function($class) {
    require(ROOT_PAGE . DS . "classes/". DS . $class . ".class.php");
});

// connecting to the database
$connection = connect_to_db();

// setting up connection for global access through class
DbObject::set_db($connection);

// echo "<pre>";
// print_r(User::find_by_sql("SELECT * FROM users"));
// echo "</pre>";

// set up session
$session = new Session;

date_default_timezone_set("Asia/Kathmandu");

$date = new DateTime();

?>