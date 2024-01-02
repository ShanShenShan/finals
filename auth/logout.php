<?php

 // Resuming the process of data

 if (isset($_GET['kiosk-logout']))
 {
    session_start(); 
    session_unset(); // releasing or giving back all information being gathered
    session_destroy();  // destroying the 
    header("location: http://localhost/pos1/kiosk/login.php");
    exit;
 }
 else
 {
    session_start(); 
    session_unset(); // releasing or giving back all information being gathered
    session_destroy();  // destroying the session
   
    header("location: http://localhost/pos1/signin.php");
 }
 

?>