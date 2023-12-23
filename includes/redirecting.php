<?php
// Check if the session variable is not set
if (!isset($_SESSION['username'])) {

    // Redirect to signin.php webpage
    header("location: " . FILEPATH . "/signin.php");
    exit(); // Ensure that no other code is executed after the redirect
}




?>