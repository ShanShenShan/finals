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

    foreach ($collected_data as $pending_data) {
        $tr_id = $pending_data->o_id;
        $product_id = $pending_data->product_id;
        $quantity = $pending_data->storage_quantity;
        $o_quantity = $pending_data->o_quantity;

        // Check if the record exists in transaction_records table
        $check_existing_record = $connection->prepare("SELECT * FROM transaction_records WHERE customer_id = :customer_id AND emp_id = :emp_id");
$check_existing_record->bindParam(':customer_id', $tr_id, PDO::PARAM_INT);
$check_existing_record->bindParam(':emp_id', $user_id, PDO::PARAM_INT);
$check_existing_record->execute();
$existing_record = $check_existing_record->fetch(PDO::FETCH_ASSOC);
// Insert into transaction product table
            $insert_transac_product = $connection->prepare("INSERT INTO transaction_products (tr_id , product_id, quantity,o_quantity) VALUES(:tr_id, :product_id, :quantity, :order_quantity)");
            $insert_transac_product->bindParam(':tr_id', $tr_id, PDO::PARAM_INT);
            $insert_transac_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $insert_transac_product->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $insert_transac_product->bindParam(':order_quantity', $o_quantity, PDO::PARAM_INT);
            $insert_transac_product->execute();

            // Updating product quantity on the storage
            $product_data_update = $connection->prepare("UPDATE inventory SET quantity = :quantity WHERE id = :product_id");
            $product_data_update->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $product_data_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $product_data_update->execute();

        if (!$existing_record) {
            

            // Inserting values on the transaction record
            $insert_transac_record = $connection->prepare("INSERT INTO transaction_records (tr_date , emp_id, customer_id,total_amount,cash_amount) VALUES(NOW(), :emp_id, :customer_id,:total_amount,:cash_amount)");
            $insert_transac_record->bindParam(':emp_id', $user_id, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':customer_id', $tr_id, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':total_amount', $total, PDO::PARAM_INT);
            $insert_transac_record->bindParam(':cash_amount', $cash_tendered, PDO::PARAM_INT);
            $insert_transac_record->execute();
        }
    }

    if (isset($_SESSION['o_id'])) {
        $code=$tr_id+1;
        $id= $_SESSION['o_id'];
        $update=$connection->query("UPDATE customers SET unique_code = $code where id=$id");
        unset($_SESSION['o_id']); // Unset the specific session variable
    }

    $deleteQuery = $connection->prepare("TRUNCATE TABLE pending_orders");
    $deleteQuery->execute();

    if("admin"==$username = $_SESSION['role'])
    {
        header("Location:" . FILEPATH . "/sales/pos.php");
        exit();
    }
    else
    {
        header("Location:" . FILEPATH . "/employee_sidebar/sales/pos.php");
        exit();
    }
    
}
?>
