<?php
require "../../includes/header.php";   
require "../../config/connection.php";
if(isset($_POST['update_description']))
{
    $product_id = $_POST["id"];
    $product_description = $_POST["description"];

    // Update the product in the database
    $updateQuery = $connection->prepare("UPDATE inventory SET 
                                    description= :description 
                                    WHERE id = :productId");

    $updateQuery->bindParam(":productId", $product_id);
    $updateQuery->bindParam(":description", $product_description);

    $updateQuery->execute();
    header("location: " . FILEPATH . "/product/product_details.php?id=$product_id");
                        exit;
}


?>