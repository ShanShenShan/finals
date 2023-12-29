<?php
require "../../config/connection.php";
require "../../includes/header.php";

$collecting_data = $connection -> query("SELECT * FROM pending_orders");
$collecting_data->execute();
$collected_data=$collecting_data->fetchAll(PDO::FETCH_OBJ);

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
}
// Redirect back to the product list page
header("Location:".FILEPATH."/sales/pos.php");
exit();
?>