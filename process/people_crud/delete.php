<?php
require "../../config/connection.php";

if (isset($_POST['delete_account_customer']) || isset($_POST['delete_account_employee']) || isset($_POST['delete_account_admin'])) {
    
    $account_id = trim($_POST['id']);
    $redirectPage = '';

    if (isset($_POST['delete_account_customer'])) {
        $table = 'customers';
        $redirectPage = '../../people/customer_list.php';
    } elseif (isset($_POST['delete_account_employee'])) {
        $table = 'employee';
        $redirectPage = '../../people/employee_list.php';
    } elseif (isset($_POST['delete_account_admin'])) {
        $table = 'admin';
        $redirectPage = '../../people/admin_list.php';
    }

    try {
        // Perform the delete operation on the specified table
        $deleteQuery = $connection->prepare("DELETE FROM $table WHERE id=:id");
        $deleteQuery->bindParam(':id', $account_id);
        $deleteQuery->execute();

        // Perform the delete operation on 'users' table
        $deleteUsersQuery = $connection->prepare("DELETE FROM users WHERE id=:id");
        $deleteUsersQuery->bindParam(':id', $account_id);
        $deleteUsersQuery->execute();

        // Redirect back to the appropriate list page
        header("Location: $redirectPage");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display the error message
        die(); // Stop execution
    }
} else {
    echo 'It was not populated';
}
?>
