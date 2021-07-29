<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// editUser.php - called by the user.php form
// to edit personal information
//
// (c) 2020, TLF
// Written by James Misa 

// START FORM PROCESSING

    $gift_method = trim($_REQUEST['method']);
    $method_username = trim($_REQUEST['username']);
    $tlf_id = $_SESSION['tlf_id'];
    $num = count($_SESSION['methods']);

        //Create new milestone	
        $query = "INSERT INTO gift_methods (
                tlf_id, 
                gift_method,
                method_username
                ) VALUES (
                '{$tlf_id}', 
                '{$gift_method}',
                '{$method_username}'
            )";

        $result = mysqli_query($connection, $query);
        confirm_query($result, $connection);

    if(mysqli_affected_rows($connection) > 0) {
        if($num < 1){$_SESSION['methods'] = array();}
        $_SESSION['methods'][$num] = array();
        $_SESSION['methods'][$num]['gift_method'] = $gift_method;
        $_SESSION['methods'][$num]['method_username'] = $method_username;
        echo "Gift method updated";
    } 
	
?>