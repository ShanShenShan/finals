<?php
require "../../config/connection.php";     // Strictly requiring to include the connection.php
// if sign-button has been clicked the below code will happen
if(isset($_POST['submit-button-edit']))
{
    // Getting values from the signin.php and removing extra spaces
    $product_id = trim($_POST['product_id']);
    $current_quantity = trim($_POST['current_quantity']);
    $customer_codes = trim($_POST['customer_code']);

    $product_data = $connection->prepare( "SELECT * FROM inventory WHERE id=:id");
    $product_data -> bindparam(':id',$product_id, pdo::PARAM_INT);
    $product_data -> execute();
    $product_info = $product_data -> fetchAll(PDO::FETCH_ASSOC);

    foreach($product_info as $product_table_info)
    {
        $product_id = $product_table_info['id'];
        $product_name = $product_table_info['product_name'];
        $category_id = $product_table_info['category_id'];
        $price = $product_table_info['price'];
        $quantity = $product_table_info['quantity'];
        $product_points = $product_table_info['product_points'];
        $image = $product_table_info['image'];
    }

    $insert = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, o_quantity, time) VALUES(:o_id, :product_id, :o_quantity, NOW())");
    $insert->bindParam(':o_id', $customer_codes, PDO::PARAM_INT);
    $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert->bindParam(':o_quantity', $current_quantity, PDO::PARAM_INT);
    $insert->execute();

    header("location: http://localhost/pos1/sales/pos.php");

}

?>