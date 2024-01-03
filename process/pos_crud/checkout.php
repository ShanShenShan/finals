<?php
require "../../config/connection.php";
require "../../includes/header.php";

if (isset($_POST['checkout-button'])) {
    $total = trim($_POST['total']);
    $cash_tendered = trim($_POST['cash-tendered']);
    $exchange = trim($_POST['change']);
    $customer_id = $_SESSION['o_id'];
    $user_id = $_SESSION['id'];

    $collecting_data = $connection->query("SELECT * FROM pending_orders");
    $collecting_data->execute();
    $collected_data = $collecting_data->fetchAll(PDO::FETCH_OBJ);

    // Read the highest id from transaction_records
    $get_highest_id = $connection->query("SELECT MAX(id) AS max_id FROM transaction_records");
    $highest_id = $get_highest_id->fetch(PDO::FETCH_ASSOC)['max_id'];

    // Increment the highest id
    $tran_id = $highest_id + 1;

    foreach ($collected_data as $pending_data) {
        $tr_id = $pending_data->o_id;
        $product_id = $pending_data->product_id;
        $quantity = $pending_data->storage_quantity;
        $o_quantity = $pending_data->o_quantity;


        

        // Insert into transaction product table
        $insert_transac_product = $connection->prepare("INSERT INTO transaction_products (tran_id,tr_id, product_id, quantity, o_quantity) VALUES(:tran_id,:tr_id, :product_id, :quantity, :order_quantity)");
        $insert_transac_product->bindParam(':tran_id', $tran_id, PDO::PARAM_INT); // Use tran_id here
        $insert_transac_product->bindParam(':tr_id', $customer_id, PDO::PARAM_INT);
        $insert_transac_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert_transac_product->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $insert_transac_product->bindParam(':order_quantity', $o_quantity, PDO::PARAM_INT);
        $insert_transac_product->execute();

        // Updating product quantity on the storage
        $product_data_update = $connection->prepare("UPDATE inventory SET quantity = :quantity WHERE id = :product_id");
        $product_data_update->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $product_data_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $product_data_update->execute();

        
            // Inserting values on the transaction record
            $insert_transac_record = $connection->prepare("INSERT INTO transaction_records (tr_date, emp_id, customer_id, total_amount, cash_amount) VALUES(NOW(), :emp_id, :customer_id, :total_amount, :cash_amount)");
            $insert_transac_record->bindParam(':emp_id', $user_id, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':total_amount', $total, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':cash_amount', $cash_tendered, PDO::PARAM_INT);
            $insert_transac_record->execute();
        
    }

    if (isset($_SESSION['o_id'])) {
        $code = $tr_id + 1;
        $id = $_SESSION['o_id'];
        $update = $connection->query("UPDATE customers SET unique_code = $code WHERE id = $id");
        unset($_SESSION['o_id']); // Unset the specific session variable
    }

    /*
        //delete pending with same o_id
        $deletePending_collect = $connection->query("SELECT o_id FROM pending_orders");
        $deletePending_collect->execute();
        $deletePending_collect = $deletePending_collect->fetchAll(PDO::FETCH_OBJ);
    
        foreach ($deletePending_collect as $collectedPending_oid) {
            $delOid = $collectedPending_oid->o_id;
    
            $deletePending = $connection->prepare("DELETE FROM pending_order_kiosk WHERE o_id = :deloid");
            $deletePending->bindParam(':deloid', $delOid, PDO::PARAM_INT);
            $deletePending->execute();
        }
    */

    $deleteQuery = $connection->prepare("TRUNCATE TABLE pending_orders");
    $deleteQuery->execute();

    if ("admin" == $username = $_SESSION['role']) {
        header("Location:" . FILEPATH . "/sales/pos.php");
        exit();
    } else {
        header("Location:" . FILEPATH . "/employee_sidebar/sales/pos.php");
        exit();
    }
}
?>
