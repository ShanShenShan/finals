<?php
require "../../config/connection.php";
require "../../includes/header.php";

if (isset($_POST['submit-button-edit'])) {
    try {
        $product_id = trim($_POST['product_id']);
        $current_quantity = trim($_POST['current_quantity']);
        $customer_codes = trim($_POST['customer_code']);

        $product_data_update = $connection->prepare("UPDATE pending_orders SET o_quantity = :current_quantity WHERE id = :product_id");
        $product_data_update->bindParam(':current_quantity', $current_quantity, PDO::PARAM_INT);
        $product_data_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $product_data_update->execute();
        
        if ($product_data_update->rowCount() === 0) {
            $product_info = $connection->prepare("SELECT id, product_name, category_id, price, quantity, product_points, image FROM inventory WHERE id=:id");
            $product_info->bindParam(':id', $product_id, PDO::PARAM_INT);
            $product_info->execute();
            $product_table_info = $product_info->fetch(PDO::FETCH_ASSOC);

            $insert = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, o_quantity, time) VALUES(:o_id, :product_id, :o_quantity, NOW())");
            $insert->bindParam(':o_id', $customer_codes, PDO::PARAM_INT);
            $insert->bindParam(':product_id', $product_table_info['id'], PDO::PARAM_INT);
            $insert->bindParam(':o_quantity', $current_quantity, PDO::PARAM_INT);
            $insert->execute();
        }

        header("Location: " . FILEPATH . "/sales/pos.php");
        exit;
    } catch (PDOException $e) {
        // Log or handle the specific PDO exception
        error_log($e->getMessage());
        header("Location: error.php"); // Redirect to an error page
        exit;
    }
}
?>
