<?php
require "../../config/connection.php";
require "../../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST["id"];
    $categoryName = $_POST["category_name"];

    // Update the Category in the database
    $updateQuery = $connection->prepare("UPDATE category SET 
                                        category_name = :categoryName
                                        WHERE id = :categoryId");

    $updateQuery->bindParam(":categoryId", $categoryId);
    $updateQuery->bindParam(":categoryName", $categoryName);

    $updateQuery->execute();

    header("location: " . FILEPATH . "/product/category_list.php");
    exit;
} else {
    echo "<script>alert('Error')</script>";
    echo "<script>window.location.href= " . FILEPATH . "/product/category_list.php";
    exit;
}

?>
