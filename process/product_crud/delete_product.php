<?php
require "../config/connection.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the image filename before deleting the record
    $fetchQuery = $connection->prepare("SELECT image FROM inventory WHERE id = :id");
    $fetchQuery->bindParam(':id', $productId);
    $fetchQuery->execute();
    $result = $fetchQuery->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Delete the image file
        $imageFilename = $result['image'];
        $imageFilePath = '../assets/img/product/' . $imageFilename;
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath);
        }

        // Perform the delete operation
        $deleteQuery = $connection->prepare("DELETE FROM inventory WHERE id = :id");
        $deleteQuery->bindParam(':id', $productId);
        $deleteQuery->execute();

        // Redirect back to the product list page
        header("Location:../product/product_list.php");
        exit();
    }
}
?>
