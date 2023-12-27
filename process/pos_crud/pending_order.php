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
        
            // Fetch customer_id based on customer_codes
            $customer_info = $connection->prepare("SELECT unique_id FROM users WHERE unique_id = :customer_codes");
            $customer_info->bindParam(':customer_codes', $customer_codes, PDO::PARAM_INT);
            $customer_info->execute();
            $customer_data = $customer_info->fetch(PDO::FETCH_ASSOC);
        
            if ($customer_data) {
                $customer_id = $customer_data['unique_id'];
        
                // Insert into pending_orders with customer_id_fk
                $insert = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, customer_id_fk, o_quantity) VALUES(:o_id, :product_id, :customer_id, :o_quantity)");
                $insert->bindParam(':o_id', $customer_codes, PDO::PARAM_INT);
                $insert->bindParam(':product_id', $product_table_info['id'], PDO::PARAM_INT);
                $insert->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $insert->bindParam(':o_quantity', $current_quantity, PDO::PARAM_INT);
                $insert->execute();
            } else {
                // Handle the case where the customer is not found
                echo "Customer not found";
            }
        }

        header("Location: " . FILEPATH . "/sales/pos.php");
        exit;
    } catch (PDOException $e) {
        // Display the error directly on the page
        echo "An error occurred: " . $e->getMessage();
        // Optionally log the error
        error_log($e->getMessage());
        // You can choose to handle the error in other ways as needed
    }
}
?>
