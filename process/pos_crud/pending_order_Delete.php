<?php
require "../../config/connection.php";
require "../../includes/header.php";
if (isset($_POST['delete_product_order'])) {
    
    $productId = $_POST['id'];

        // Perform the delete operation
        $deleteQuery = $connection->prepare("DELETE FROM pending_orders WHERE id = :id");
        $deleteQuery->bindParam(':id', $productId);
        $deleteQuery->execute();

        // Redirect back to the product list page
        header("Location:".FILEPATH."/sales/pos.php");
        exit();
    
}
else if (isset($_POST['clear-all'])) {
    

        $deleteQuery = $connection->prepare("TRUNCATE TABLE pending_orders");
        $deleteQuery->execute();

        // Redirect back to the product list page
        header("Location:".FILEPATH."/sales/pos.php");
        exit();
    
}
?>
