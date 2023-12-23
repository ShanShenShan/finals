<?php
require "../../config/connection.php"; // importing connectivity
require "../../includes/header.php"; // importing header

if(isset($_POST['update_customer_button'])|| isset($_POST['update_employee_button'])|| isset($_POST['update_admin_button']))
{
    $account_id = trim($_POST['id']);
    $account_name = trim($_POST['name']);
    $account_email = trim($_POST['email']);
    $redirectPage = '';

    if (isset($_POST['update_customer_button'])) {
        $table = 'customers';
        $redirectPage = '../../people/customer_list.php';
    } elseif (isset($_POST['update_employee_button'])) {
        $table = 'employee';
        $redirectPage = '../../people/employee_list.php';
    } elseif (isset($_POST['update_admin_button'])) {
        $table = 'admin';
        $redirectPage = '../../people/admin_list.php';
    }

    try {
        // Perform the update operation on the specified table
        $update_query = $connection->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $update_query->bindParam(':name', $account_name, PDO::PARAM_STR);
        $update_query->bindParam(':email', $account_email, PDO::PARAM_STR);
        $update_query->bindParam(':id', $account_id, PDO::PARAM_INT);
        $update_query->execute();

        // Redirect back to the appropriate list page
        header("Location: $redirectPage");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display the error message
        die(); // Stop execution
    }
}
else 
{
    echo 'It was not populated';
}



?>