<?php

require "../../config/connection.php";

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input
    $orderId = filter_input(INPUT_POST, 'orderId', FILTER_SANITIZE_NUMBER_INT);

    // Delete existing entries in pending_orders for the specified order ID
    $deleteQuery = $connection->prepare("DELETE FROM pending_orders");
    $deleteQuery->execute();

    // Query to insert entries into pending_orders
    $insertQuery = $connection->prepare("INSERT INTO pending_orders (o_id, product_id, customer_id, o_quantity, storage_quantity)
                                        SELECT po.o_id, po.product_id, po.customer_id, po.o_quantity, (inv.quantity - po.o_quantity) AS storageQuantityValue
                                        FROM pending_order_kiosk po
                                        JOIN inventory inv ON po.product_id = inv.id
                                        WHERE po.o_id = :orderId");
    $insertQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $insertQuery->execute();

    // Store o_id in the session
    $_SESSION['o_id'] = $orderId;

    // Output a success message
    echo "Entries transferred successfully to pending_orders!";
}
?>
