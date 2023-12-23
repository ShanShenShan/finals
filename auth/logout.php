<?php
 session_start(); // Resuming the process of data
 session_unset(); // releasing or giving back all information being gathered
 session_destroy();  // destroying the session

 header("location: http://localhost/pos1/signin.php");

?>