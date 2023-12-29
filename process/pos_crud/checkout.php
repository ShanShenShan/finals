<?php
require "../../config/connection.php";
require "../../includes/header.php";

if(isset($_POST['checkout-button']))
{
    $total = trim($_POST['total']);
    $cash_tendered = trim($_POST['cash-tendered']);
    $exchange = trim($_POST['change']);
    $user_id= $_SESSION['id'];

$collecting_data = $connection -> query("SELECT * FROM pending_orders");
$collecting_data->execute();
$collected_data=$collecting_data->fetchAll(PDO::FETCH_OBJ);

//copying all of the data in the pending table
foreach($collected_data as $pending_data)
{
    $tr_id = $pending_data -> customer_id;
    $product_id = $pending_data -> product_id;
    $quantity = $pending_data -> storage_quantity;

    // Insert into transaction product table
    $insert_transac_product = $connection->prepare("INSERT INTO transaction_products (tr_id , product_id, quantity) VALUES(:tr_id, :product_id, :quantity)");
    $insert_transac_product->bindParam(':tr_id', $tr_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $insert_transac_product->execute();

    // Updating product quantity on the storage
    $product_data_update = $connection->prepare("UPDATE inventory SET quantity = :quantity WHERE id = :product_id");
    $product_data_update->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $product_data_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $product_data_update->execute(); 

    // Inserting values on the transaction record
    $insert_transac_product = $connection->prepare("INSERT INTO transaction_records (tr_date , emp_id, customer_id,total_amount,cash_amount) VALUES(NOW(), :emp_id, :customer_id,:total_amount,:cash_amount)");
    $insert_transac_product->bindParam(':emp_id', $user_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':customer_id', $tr_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':total_amount', $total, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':cash_amount', $cash_tendered, PDO::PARAM_INT);
    $insert_transac_product->execute();
}
//removing the order id session to be able to recyle a new one
if (isset($_SESSION['o_id'])) {
    unset($_SESSION['o_id']); // Unset the specific session variable
}
//Removing all of the values in the table
$deleteQuery = $connection->prepare("TRUNCATE TABLE pending_orders");
$deleteQuery->execute();

header("Location:".FILEPATH."/sales/pos.php");
exit();
}
?>