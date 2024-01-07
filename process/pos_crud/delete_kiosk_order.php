<?php
require "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['orderId'];

    // Debugging: Log received data
    error_log('Received orderId for deletion: ' . $orderId);

    // Implement the deletion query
    $deleteQuery = $connection->prepare("DELETE FROM pending_order_kiosk WHERE o_id = :orderId");
    $deleteQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);

    try {
        $deleteQuery->execute();

        // Log successful deletion
        error_log('Order deleted successfully for orderId: ' . $orderId);

        echo "Order deleted successfully.";
    } catch (PDOException $e) {
        // Handle errors, log them, or provide an error message

        // Log the error
        error_log('Error deleting order: ' . $e->getMessage());

        echo "Error deleting order: " . $e->getMessage();
    }
} else {
    // Handle invalid requests (e.g., direct access to this file)

    // Log the invalid request
    error_log("Invalid request.");

    echo "Invalid request.";
}
?>
