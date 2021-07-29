<?php
require("constants.php");
$localhost = array(
    '127.0.0.1',
    '::1'
);


//if (!logged_in()){
//    if((basename($_SERVER['PHP_SELF']) != "index.php") && (basename($_SERVER['PHP_SELF']) != "joinnow.php") && (basename($_SERVER['PHP_SELF']) != "ten8ight.php") && (basename($_SERVER['PHP_SELF']) != "ten8ight_update.php") && (basename($_SERVER['PHP_SELF']) != "findReferrer.php") && (basename($_SERVER['PHP_SELF']) != "processLogin.php") && (basename($_SERVER['PHP_SELF']) != "newUser3.php") && (basename($_SERVER['PHP_SELF']) != "resetPassword.php")) {
//        header("Location: index.php");
//    }
//}

if(in_array($_SERVER['REMOTE_ADDR'], $localhost)){

	$connection = mysqli_connect(DB_SERVER_L,DB_USER_L,DB_PASS_L); 
	if (!$connection) {
		die("Database connection failed: " . mysqli_error($connection));
	}

	// 2. Select a database to use 
	$db_select = mysqli_select_db($connection, DB_NAME_L);
	if (!$db_select) {
		die("Database selection failed: " . mysqli_error($connection));
	}
	define('BASE_URL', 'http://localhost/~macbookair/ujamaa/');
} else {
    $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS); 
	if (!$connection) {
		die("Database connection failed: " . mysqli_error($connection));
	}

	// 2. Select a database to use 
	$db_select = mysqli_select_db($connection, DB_NAME);
	if (!$db_select) {
		die("Database selection failed: " . mysqli_error($connection));
	}
	define('BASE_URL', "184.168.131.241");
}



?>