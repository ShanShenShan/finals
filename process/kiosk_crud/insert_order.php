<?php

// Include your database connection file
require "../../config/connection.php";

// Retrieve the SQL statement from the AJAX request
$sql = isset($_POST['sql']) ? $_POST['sql'] : '';

if (!empty($sql)) {
    try {
        // Execute the SQL statement
        $connection->exec($sql);

        // Send a success response to the client
        echo json_encode(array('status' => 'success'));
    } catch (PDOException $e) {
        // Handle errors and send an error response to the client
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
    }
} else {
    // Send an error response if SQL statement is empty
    echo json_encode(array('status' => 'error', 'message' => 'Empty SQL statement'));
}

?>
