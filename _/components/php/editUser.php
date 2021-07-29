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

    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $email = trim($_REQUEST['email']);
    $phone = trim($_REQUEST['phone']);
    $hobbies = trim($_REQUEST['hobbies']);
    $book = trim($_REQUEST['book']);
    $website = trim($_REQUEST['website']);
    $referrer_name = trim($_REQUEST['referrer_name']);
    $tlf_id = trim($_REQUEST['tlf_id']);	

    $num = count($_SESSION['boardWater']);
    for($i=0; $i<$num; $i++) {
        if($referrer_name == $_SESSION['boardWater'][$i]['name']) {
            $ref_tlf_id = trim($_SESSION['boardWater'][$i]['tlf_id']);
        }
    }

        //Update user	
        $query = "UPDATE users 
                  SET 
                    first_name='{$first_name}',
                    last_name='{$last_name}', 		
                    email='{$email}', 	
                    phone='{$phone}',
                    hobbies='{$hobbies}',
                    book='{$book}',
                    website='{$website}',
                    referrer_name='{$referrer_name}',
                    referrer='{$ref_tlf_id}',
                    referrer_ten8='{$ref_tlf_id}'
                  WHERE 
                    tlf_id='{$tlf_id}'
                 ";
     echo $query;
     
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);

    if(mysqli_affected_rows($connection) > 0) {
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['referrer_name'] = $referrer_name;
        $_SESSION['website'] = $website;
        $_SESSION['hobbies'] = $hobbies;
        $_SESSION['book'] = $book;
        echo "User updated";
    } 
	
?>