<?php
ob_start();
session_start();

//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','cafet3ch_php_login_system_chalange');

try {
    //create PDO connection
    $db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
} catch(PDOException $e) {
    //show error
    error_log('Connection failed: '.$e->getMessage());exit;
}


include('user_class.php');

//Sanitize request POST
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$user = new User($db);

?>