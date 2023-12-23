<?php
require "../includes/header.php"; // Strictly requiring to include the header.php
require "../config/connection.php"; // Strictly requiring to include the connection.php


if(isset($_POST['recovery-button'])) {
    $code = trim($_POST['recovery']);

    $search = $connection->prepare("SELECT * FROM users WHERE recovery_code = :code");
    $search->bindParam(":code", $code, PDO::PARAM_INT); // Assuming recovery_code is a string in the database
    $search->execute();
    $data = $search->fetch(PDO::FETCH_ASSOC); // Fetching all row

    if( $data) {
        $user_role = $data["role"];
        $name = $data["name"];
        $email = $data["Email"];
        // Declaring session to retrieve values into another webpage
        $_SESSION['username'] = $name;
        $_SESSION['role'] = $user_role;
        $_SESSION['email'] =  $email;
        
        // Redirect based on user role
        switch ($user_role) {
            case 'employee':
                header("location: " . FILEPATH . "/employee_sidebar/employee_index.php");
                exit;
            case 'customer':
                header("location: " . FILEPATH . "/customer_ui/customer_index.php");
                exit;
            case 'admin':
                header("location: " . FILEPATH . "/admin_index.php");
                exit;
            default:
                error_feedback("Invalid user role");
        }
    } else {
        echo "<script>alert('The input Recovery code doesn\\'t exist')</script>";
        echo "<script>window.location.href='" . FILEPATH . "/recover.php'</script>";
    }
}
?>
