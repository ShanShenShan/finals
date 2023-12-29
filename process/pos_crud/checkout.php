<?php
require "../../config/connection.php";
require "../../includes/header.php";

if(isset($_POST['checkout-button']))
{
    $total = trim($_POST['total']);
    $cash_tendered = trim($_POST['cash-tendered']);
    $exchange = trim($_POST['change']);

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
    $insert_transac_product = $connection->prepare("INSERT INTO transaction_products (tr_id , product_id, quantity,total,cash_amount,exchange) VALUES(:tr_id, :product_id, :quantity,:total,:cash_amount,:exchange)");
    $insert_transac_product->bindParam(':tr_id', $tr_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':total', $total, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':cash_amount', $cash_tendered, PDO::PARAM_INT);
    $insert_transac_product->bindParam(':exchange', $exchange, PDO::PARAM_INT);
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