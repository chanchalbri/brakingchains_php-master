<?php 
// logout.php - called by the logout button 
// to log the user out by destroying all sessions
//
// (c) 2018, 5Onit
// Written by James Misa 

session_start();
session_destroy ();
header("location:index.php");

?>
