<?php
// Trying to run a code which having a high propability to make an error
try
{
    // Defining a constant value 
    define("host","localhost");
    define("user","root");
    define("password","");
    define("database","pos2");

    // Setting up a connection into the database that we have
    $connection = new pdo("mysql: host=".host."; dbname=".database.";",user,password);
    
    // Generating an error message
    $connection->setAttribute(pdo::ATTR_ERRMODE,pdo::ERRMODE_EXCEPTION);


}catch(PDOException $error) // When the trial run code has been failed it will fetch the error message
{
    // The database will be close eventually and it will display its reason of failure
    die("connection has been failed miserbly reason was ". $error->getMessage());
}



?>