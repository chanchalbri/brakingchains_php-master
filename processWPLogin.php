<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connect.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php
// processLogin.php - called by the login.php form 
// to process login validation
//
// (c) 2020, TLF
// Written by James Misa 

date_default_timezone_set('America/Los_Angeles');
// START FORM PROCESSING
$errors = array();

// perform validations on the form data
//$required_fields = array('email', 'password');
//$errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

$wordpress_user_id = trim($_REQUEST['id']);

if (empty($errors)) {
    // Check database to see if username and the hashed password exist there.
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE wordpress_user_id = '{$wordpress_user_id}' ";
    //$query .= "AND hashed_password = '{$hashed_password}' ";
    $query .= "ORDER BY creation_date_time ASC ";
    $query .= "LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    if (mysqli_num_rows($resultSet) == 1) {
        // username/password authenticated
        while($foundUser = mysqli_fetch_array($resultSet)) {
            $tlf_id = $foundUser['tlf_id'];
            $_SESSION['tlf_id'] = $foundUser['tlf_id'];
            $_SESSION['first_name'] = $foundUser['first_name'];
            $_SESSION['last_name'] = $foundUser['last_name'];
            $_SESSION['display_name'] = $foundUser['display_name'];
            $_SESSION['email'] = $foundUser['email'];
            $_SESSION['phone'] = $foundUser['phone'];
            $_SESSION['hashed_password'] = $foundUser['hashed_password'];
            $_SESSION['referrer'] = $foundUser['referrer'];
            $_SESSION['referrer_name'] = $foundUser['referrer_name'];
            $formatted_fireDate = date("m/d/Y", $foundUser['fireDate']);
            $_SESSION['fireDate'] = $formatted_fireDate;
            if($foundUser['air_id'] == NULL){$_SESSION['seed'] = 1;}else{$_SESSION['seed']=0;}
            $_SESSION['gen'] = $foundUser['gen'];
            $_SESSION['flower'] = $foundUser['flower'];
            $_SESSION['admin'] = $foundUser['admin'];
            $_SESSION['promoCode'] = $foundUser['promoCode'];
            $_SESSION['view'] = $foundUser['view'];
            $terms = $foundUser['terms'];
        }

        if($_SESSION['flower'] == 0) {
            $query = "SELECT *";
            $query .= "FROM milestones ";
            $query .= "WHERE tlf_id = '{$tlf_id}'";
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);
            while($milestone = mysqli_fetch_array($resultSet)) {
                $percentage = $milestone['percentage'];
                if($percentage == 0){
                    $_SESSION['next_milestone'] = 'm_one';
                    } elseif ($percentage == 20) {
                        $_SESSION['next_milestone'] = 'm_two';
                    } elseif ($percentage == 40) {
                        $_SESSION['next_milestone'] = 'm_three';
                    } elseif ($percentage == 60) {
                        $_SESSION['next_milestone'] = 'm_four';
                    } elseif ($percentage == 80) {
                        $_SESSION['next_milestone'] = 'm_five';
                    } else {
                        $_SESSION['next_milestone'] = 'complete';
                    }
                }

            $_SESSION['percentage'] = $percentage;
        }
        $query = "SELECT * ";
        $query .= "FROM gift_methods ";
        $query .= "WHERE tlf_id = '{$tlf_id}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        if(mysqli_num_rows($resultSet) > 0) {
            $i = 0;
            $_SESSION['methods'] = array();
            while($method = mysqli_fetch_array($resultSet)) {
                $_SESSION['methods'][$i] = array();
                $_SESSION['methods'][$i]['gift_method'] = $method['gift_method'];
                $_SESSION['methods'][$i]['method_username'] = $method['method_username'];
                $i++;
            }
        }

        $msg = array();
        $msg[0] = "Success";
        $msg[1] = $terms;
        $msg[2] = $tlf_id;
    ?>
        <script>
            localStorage.setItem("logged_in", "IN");
            localStorage.setItem("terms", '<?php echo $terms ?>');
            window.location.href = "index.php";
        </script>
    <?php
    } else {//if username/password do not match
        $msg = array();
        $msg[0] = "Error";
        $msg[1] = "Username & Password combo do not match.";
        ?>
        <script>
            alert('Username & Password combo do not match.');
            window.location.href = "index.php";
        </script>
        <?php
    }
} else {//if not empty errors
    $msg = "There are errors";
    ?>
    <script>
        alert('There are errors');
        window.location.href = "index.php";
    </script>
    <?php
}
?>
