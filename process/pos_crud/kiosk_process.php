<?php 
require "../../config/connection.php";
require "../../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all'])) {
    $deleteQuery = $connection->prepare("TRUNCATE TABLE pending_order_kiosk");
    if ($deleteQuery->execute()) {
        // Provide a success response (optional)
        echo "Data cleared successfully!";
    } else {
        // Provide an error response (optional)
        http_response_code(500);
        echo "Error clearing data!";
    }
    exit();
}
?>