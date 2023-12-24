<?php
require "../includes/header.php";       // Strictly requiring to include the header.php
require "../config/connection.php";     // Strictly requiring to include the connection.php

// Function tha has been called several times
function feedback($message)
{
    echo "<script>alert('$message')</script>";
    echo "<script>window.location.href=" . FILEPATH . "/signup.php</script>";
}

// Use functions for better readability, Data admin insertion process.
function insert_admin($connection, $password, $username, $email, $role)
{
    // Generating salt and hashing the password for security
    $salt = bin2hex(random_bytes(22));
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 12]);

    // Generating 4 digit code
    $recovery_code = rand(1000, 9999);

    // Inserting values on the database table using a safe method to avoid SQL injections
    $insert_admin = $connection->prepare("INSERT INTO admin (recovery_code) VALUES(:recovery)");
    $insert_admin->bindParam(":recovery", $recovery_code, PDO::PARAM_INT);
    $insert_admin->execute();

    // Query to get the last inserted id on the table
    $gather = $connection->query("SELECT LAST_INSERT_ID() as last_id");
    $id = $gather->fetch(PDO::FETCH_OBJ)->last_id;

     // Inserting values on the database table using a safe method to avoid SQL injections
    $insert = $connection->prepare("INSERT INTO users (id, name, email, role, salt, password) VALUES (:id, :name, :email, :role, :salt, :password)");

    $insert->bindParam(":id", $id, PDO::PARAM_INT); 
    $insert->bindParam(":name", $username, PDO::PARAM_STR);
    $insert->bindParam(":email", $email, PDO::PARAM_STR);
    $insert->bindParam(":role", $role, PDO::PARAM_STR);
    $insert->bindParam(":salt", $salt, PDO::PARAM_STR);
    $insert->bindParam(":password", $hashedpassword, PDO::PARAM_STR);
    $insert->execute();
}

// Use functions for better readability
function insert_emplopyee($connection, $password, $username, $email, $role)
{
    // Generating salt and hashing the password for security
    $salt = bin2hex(random_bytes(22));
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 12]);

    // Generating 4 digit code
    $recovery_code = rand(1000, 9999);

    // Inserting values on the database table using a safe method to avoid SQL injections
    $insert_employee = $connection->prepare("INSERT INTO employee (recovery_code) VALUES(:recovery)");
    $insert_employee->bindParam(":recovery", $recovery_code, PDO::PARAM_INT);
    $insert_employee->execute();

    // Query to get the last inserted id on the table
    $gather = $connection->query("SELECT LAST_INSERT_ID() as last_id");
    $id = $gather->fetch(PDO::FETCH_OBJ)->last_id;

    // Inserting values on the database table using a safe method to avoid SQL injections
    $insert = $connection->prepare("INSERT INTO users (id, name, email, role, salt, password) VALUES (:id, :name, :email, :role, :salt, :password)");

    $insert->bindParam(":id", $id, PDO::PARAM_INT); // Assuming 'id' in users table is auto-incremented
    $insert->bindParam(":name", $username, PDO::PARAM_STR);
    $insert->bindParam(":email", $email, PDO::PARAM_STR);
    $insert->bindParam(":role", $role, PDO::PARAM_STR);
    $insert->bindParam(":salt", $salt, PDO::PARAM_STR);
    $insert->bindParam(":password", $hashedpassword, PDO::PARAM_STR);
    $insert->execute();
}

function insert_customers($connection, $password, $username, $email, $role)
{
    // Generating salt and hashing the password for security
    $salt = bin2hex(random_bytes(22));
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 12]);

    // Generating 4 digit code
    $recovery_code = rand(1000, 9999);
    $initial_points = 0;

    // Inserting values on the database table using a safe method to avoid SQL injections
    $insert_employee = $connection->prepare("INSERT INTO customers (recovery_code,points,unique_code) VALUES(:recovery,:points,:unique_code)");
    $insert_employee->bindParam(":recovery", $recovery_code, PDO::PARAM_INT);
    $insert_employee->bindParam(":points", $initial_points, PDO::PARAM_INT);
    $insert_employee->bindParam(":unique_code", $recovery_code, PDO::PARAM_INT);
    $insert_employee->execute();

    // Query to get the last inserted id on the table
    $gather = $connection->query("SELECT LAST_INSERT_ID() as last_id");
    $id = $gather->fetch(PDO::FETCH_OBJ)->last_id;

    // Inserting values on the database table using a safe method to avoid SQL injections
    $insert = $connection->prepare("INSERT INTO users (id, name, email, role, salt, password) VALUES (:id, :name, :email, :role, :salt, :password)");
    $insert->bindParam(":id", $id, PDO::PARAM_INT); 
    $insert->bindParam(":name", $username, PDO::PARAM_STR);
    $insert->bindParam(":email", $email, PDO::PARAM_STR);
    $insert->bindParam(":role", $role, PDO::PARAM_STR);
    $insert->bindParam(":salt", $salt, PDO::PARAM_STR);
    $insert->bindParam(":password", $hashedpassword, PDO::PARAM_STR);

    $insert->execute();
}

try {
    if (isset($_POST['register-button'])) 
    {
        // Extracting user input, removing all whitelines
        $username = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Allowed email domains
        $allowedDomains = ['employee.com', 'customer.com', 'admin.com'];
        // Extracting the domain name ex. employee.com
        $emailParts = explode('@', $email);
        // removing the values on emailparts and assigning it into new variable
        $domain = array_pop($emailParts);
        // Extracting the role ex. employee.com
        $domain_part = explode('.', $domain);
        $role = $domain_part[0];

        // Validating email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            feedback("The Given E-mail address was set into an incorrect format");
            exit;
        }

        // Checking if the email domain is allowed
        if (!in_array($domain, $allowedDomains)) {
            feedback("The inserted E-mail domain was in an incorrect format");
            exit;
        }

        // Checking if the email already exists
        $search = $connection->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $search->bindParam(":email", $email, PDO::PARAM_STR);
        $search->execute();
        $email_count = $search->fetchColumn();

        if ($email_count > 0) {
            feedback("Email has been already Exist!!");
            exit;
        }

        // Validating password criteria
        if (strlen($password) < 6 || !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) {
            feedback("Password must be at least 6 characters long and contain both upper and lower case characters");
            exit();
        } else {
            
            // Redirect the process based on the current session role
            switch ($_SESSION['role']) {
                case 'admin':
                    // Redirecting registration process based on their roles
                    switch ($role) {
                        case 'admin':
                            insert_admin($connection, $password, $username, $email, $role);
                            echo "<script>window.location.href='" . FILEPATH . "/people/admin_list.php'</script>";
                            break;
                        case 'employee':
                            insert_emplopyee($connection, $password, $username, $email, $role);
                            echo "<script>alert('Creating an account successfuly!')</script>";
                            echo "<script>window.location.href='" . FILEPATH . "/people/add_employee.php'</script>";
                            break;
                        case 'customer':
                            insert_customers($connection, $password, $username, $email, $role);
                            echo "<script>alert('Creating an account successfuly!')</script>";
                            echo "<script>window.location.href='" . FILEPATH . "/people/add_customer.php'</script>";
                            break;
                        default:
                            feedback("Unexpected user role");
                    }

                    // Displaying success message
                    feedback("Account Created successfully!!");
                    break;
                case 'employee':
                    
                    // Calling the insertion function
                    insert_customers($connection, $password, $username, $email, $role);
                    echo "<script>alert('Creating an account successfuly!')</script>";
                    echo "<script>window.location.href='" . FILEPATH . "/employee_sidebar/people/add_customer.php'</script>";
                    break;
                default:
                    feedback("Unexpected user role");
                    break;
            }
        }
    }
} catch (PDOException $error) {
    // Logging errors
    error_log("There is a problem within the server. The reason is " . $error->getMessage());
}