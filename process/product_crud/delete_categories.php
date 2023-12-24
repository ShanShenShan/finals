<?php
require "../../config/connection.php";
require "../../includes/header.php";
if (isset($_POST['delete_category'])) {
    
    $category_Id = $_POST['id'];

        // Perform the delete operation
        $deleteQuery = $connection->prepare("DELETE FROM category WHERE id = :id");
        $deleteQuery->bindParam(':id', $category_Id);
        $deleteQuery->execute();

        // Redirect back to the product list page
        header("Location:".FILEPATH."/product/category_list.php");
        exit();
    
}
?>
