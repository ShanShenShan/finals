<?php
require "../includes/header.php"; // Strictly requiring to include the header.php
require "../config/connection.php"; // Strictly requiring to include the connection.php

if(isset($_POST['recovery-button'])) {
    $code = trim($_POST['recovery']);
    $email = trim($_POST['email']);

$select = $connection->prepare("SELECT * FROM users WHERE Email=:email");
$select->bindParam(":email",$email,PDO::PARAM_STR);
$select->execute();
$data=$select->fetch(PDO::FETCH_OBJ);

$select_code = $connection->prepare(" SELECT recovery_code FROM admin WHERE id = :users_id
UNION
SELECT recovery_code FROM customers WHERE id = :users_id
UNION
SELECT recovery_code FROM employee WHERE id = :users_id");
$select_code->bindParam(":users_id",$data->id,PDO::PARAM_STR);
$select_code->execute();
$code=$select_code->fetch(PDO::FETCH_OBJ);

    if( $data) {
        $user_role = $data->role;
        $name = $data->name;
        $email = $data->email;
        $code = $data->recovery_code;
        $user_id = $data->id;
        // Declaring session to retrieve values into another webpage
        $_SESSION['username'] = $name;
        $_SESSION['role'] = $user_role;
        $_SESSION['email'] =  $email;
        $_SESSION['code'] =  $code;
        $_SESSION['id'] =  $user_id;
        
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
if(isset($_POST['x_recovery-button'])) {
    $code = trim($_POST['recovery']);
    $email = trim($_POST['email']);

$select = $connection->prepare("SELECT * FROM users WHERE Email=:email");
$select->bindParam(":email",$email,PDO::PARAM_STR);
$select->execute();
$data=$select->fetch(PDO::FETCH_OBJ);

    if( $data) {
        $user_role = $data->role;
        $name = $data->name;
        $email = $data->email;
        $user_id= $data->id;
        // Declaring session to retrieve values into another webpage
        $_SESSION['username'] = $name;
        $_SESSION['role'] = $user_role;
        $_SESSION['email'] =  $email;
        $_SESSION['id'] =  $user_id;
        
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
