<?php
require "../../config/connection.php";
require "../../includes/header.php";

if (isset($_POST['submit-button-edit'])) {
    try {
        $product_id = trim($_POST['product_id']);
        $current_quantity = trim($_POST['current_quantity']);
        $customer_id = trim($_POST['customer_id']);
        $availability = trim($_POST['avalability']);


        //updating data on pending orders table
        $product_data_update = $connection->prepare("UPDATE pending_orders SET o_quantity = :current_quantity WHERE id = :product_id");
        $product_data_update->bindParam(':current_quantity', $current_quantity, PDO::PARAM_INT);
        $product_data_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $product_data_update->execute();

        //updating data on transac table

          
        if ($product_data_update->rowCount() === 0) {
            $product_info = $connection->prepare("SELECT id, product_name, category_id, price, quantity, product_points, image FROM inventory WHERE id=:id");
            $product_info->bindParam(':id', $product_id, PDO::PARAM_INT);
            $product_info->execute();
            $product_table_info = $product_info->fetch(PDO::FETCH_ASSOC);
        
            $customer_info = $connection->prepare("SELECT unique_code FROM customers WHERE id = :id");
            $customer_info->bindParam(':id', $customer_id, PDO::PARAM_INT);
            $customer_info->execute();
            $customer_data = $customer_info->fetch(PDO::FETCH_ASSOC);
        
            if ($customer_data) {
                $customer_codes = $customer_data['unique_code'];               
        
                // Insert into pending_orders with customer_id_fk
                $insert = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, customer_id, o_quantity,storage_quantity) VALUES(:o_id, :product_id, :customer_id, :o_quantity,:storage)");
                $insert->bindParam(':o_id', $customer_codes, PDO::PARAM_INT);
                $insert->bindParam(':product_id', $product_table_info['id'], PDO::PARAM_INT);
                $insert->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $insert->bindParam(':o_quantity', $current_quantity, PDO::PARAM_INT);
                $insert->bindParam(':storage', $availability, PDO::PARAM_INT);
                $insert->execute();

                
            } else {
                // Handle the case where the customer is not found
                echo "Customer not found";
            }
        }
        header("location: " . FILEPATH . "/sales/pos.php");
        exit;
        
        
    } catch (PDOException $e) {
        // Display the error directly on the page
        echo "An error occurred: " . $e->getMessage();
        // Optionally log the error
        error_log($e->getMessage());
        // You can choose to handle the error in other ways as needed
    }
}
elseif(isset($_POST['pending_list']))
{
    // select all kiosk data
    $retrieving_data = $connection->query("SELECT * FROM pending_order_kiosk");
    $retrieving_data->execute();
    $kiosk_data = $retrieving_data->fetchAll(PDO::FETCH_OBJ);
    foreach ($kiosk_data as $data) 
    {
        $order_id = $data->o_id;
        $customer_id = $data->customer_id;
        $product_id = $data->product_id;
    }

    // Selecting all the values that should be seen on the modal
    $query = $connection->prepare("SELECT i.product_name, c.category_name, po.o_quantity, i.product_points, i.price,i.quantity as storage
    FROM pending_order_kiosk po
    JOIN inventory i ON po.product_id = i.id
    JOIN category c ON i.category_id = c.id
    WHERE po.o_id = :orderId");
    $query->bindParam(':orderId', $order_id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_OBJ);

    foreach ($data as $information) 
    {
    $product_name = $information->product_name;
    $category_name = $information->category_name;
    $order_quantity = $information->o_quantity;

    $totalPrice = $information->price * $information->o_quantity;
    $storage = $information->storage;
    }

    // Insert into pending_orders with customer_id_fk
    $insert = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, customer_id, o_quantity,storage_quantity) VALUES(:o_id, :product_id, :customer_id, :o_quantity,:storage)");
    $insert->bindParam(':o_id', $order_id, PDO::PARAM_INT);
    $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $insert->bindParam(':o_quantity', $order_quantity, PDO::PARAM_INT);
    $insert->bindParam(':storage', $storage, PDO::PARAM_INT);
    $insert->execute();

    // Perform the delete operation
    $deleteQuery = $connection->prepare("TRUNCATE TABLE pending_order_kiosk");
    $deleteQuery->execute();

    header("location: " . FILEPATH . "/sales/pos.php");
    exit;
}
?>
