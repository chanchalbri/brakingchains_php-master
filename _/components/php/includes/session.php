<?php
	session_start();
	
	function logged_in() {
		return ((isset($_SESSION['tlf_id'])) && (!empty($_SESSION['tlf_id'])));
	}
	
	function confirm_logged_in($field) {
		if (logged_in()) {
            $t = time();
            $t0 = $_SESSION[$field];
            $diff = $t - $t0;
            if ($diff > 1500 || !isset($t0)) {
                session_unset();
                session_destroy();       
                exit;
            } else {
                $_SESSION[$field] = time();
            }
        }
	}
	
	function confirm_usertype() {
		if ($_SESSION['admin'] == "0") {
		}
	}
?>