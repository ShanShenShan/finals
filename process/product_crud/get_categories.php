<?php
require "../../config/connection.php";

// Query to select all category names
$search = $connection->query("SELECT * FROM category");
$search->execute();

$categories = $search->fetchAll(PDO::FETCH_ASSOC);

// Return categories as JSON
echo json_encode($categories);
?>