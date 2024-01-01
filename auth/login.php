<?php
require "../includes/header.php";       // Strictly requiring to include the header.php
require "../config/connection.php";     // Strictly requiring to include the connection.php

session_start();

// if there is no session being set it will forcefully go into signin.php
if (!isset($_SESSION['username'])) {
    header("location: " . FILEPATH . "/signin.php");
}

// if sign-button has been clicked the below code will happen
if (isset($_POST['signin-button'])) {

    // Getting values from the signin.php and removing extra spaces
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        // Getting all data from database using the inserted email
        // Making sure that the inputfield carrying data not a command
        $search = $connection->prepare('SELECT * FROM users WHERE Email = :email');
        $search->bindParam(":email", $email, PDO::PARAM_STR);
        $search->execute();

        // Fetching the gathared data into an assiciative array
        $user = $search->fetch(PDO::FETCH_ASSOC);

        // If the variables has been populated the inside code will happen
        if ($user) 
        {
            // Getting all the fetch data from the $user, Accessing its data using column name and assigning it into variables
            $dbpassword = $user['password'];
            $username = $user['name'];
            $user_role = $user['role'];
            $user_id = $user['id'];

            // matching the inserted password into the salted password from tha database
            if (password_verify($password, $dbpassword)) 
            {
                // Declaring session to retrieve values into another webpage
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user_role;
                $_SESSION['email'] = $email ;
                $_SESSION['id'] = $user_id ;

                // Redirect based on user role
                switch ($user_role) 
                {
                    case 'employee':
                        header("location: " . FILEPATH . "/employee_sidebar/employee_index.php");
                        exit;
                    case 'customer':
                        $_SESSION['kiosk_email'] = $email ;
                        header("location: " . FILEPATH . "/kiosk/index.php");
                        exit;
                    case 'admin':
                        header("location: " . FILEPATH . "/admin_index.php");
                        exit;
                    default:
                        error_feedback("Invalid user role");
                }
            } else {
                error_feedback("Password doesn't match");
            }
        } else {
            error_feedback("Email not registered");
        }
    } else {
        error_feedback("Invalid email format");
    }
} else {
    header("location: " . FILEPATH . "/signin.php");
    exit;
}

// function that returns a feedback and redirect the user
function error_feedback($message)
{
    echo "<script>alert('$message')</script>";
    echo "<script>window.location.href= " . FILEPATH . "/signin.php</script>";
    exit;
}
?>
