<?php
// Include your database connection file
require "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input
    $orderId = filter_input(INPUT_POST, 'orderId', FILTER_SANITIZE_NUMBER_INT);

    // Query to fetch order details and group by o_id
    $query = $connection->prepare("SELECT i.product_name, c.category_name, po.o_quantity, i.product_points, i.price
        FROM pending_orders po
        JOIN inventory i ON po.product_id = i.id
        JOIN category c ON i.category_id = c.id
        WHERE po.o_id = :orderId");
    $query->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $query->execute();

    $orderDetails = $query->fetchAll(PDO::FETCH_OBJ);

    // Output the HTML content for the order details table body
    foreach ($orderDetails as $detail) {
        $totalPrice = $detail->price * $detail->o_quantity;
        $totalPoints = $detail->product_points * $detail->o_quantity;

        echo "<tr>
                <td>{$detail->product_name}</td>
                <td>{$detail->category_name}</td>
                <td>{$detail->o_quantity}</td>
                <td>{$totalPoints}</td>
                <td>{$totalPrice}</td>
            </tr>";
    }
}
?>
