<?php
require "../../includes/header.php";
require "../../config/connection.php";

function feedback($message)
{
    echo "<script>alert('$message');</script>";
    echo "<script>window.location.href='" . FILEPATH . "/product/product_list.php';</script>";
}

if (isset($_POST['submit-button'])) {
    $product_name = trim($_POST['product_name']);
    $category_id = trim($_POST['category_id']); // Change to category_id
    $product_price = trim($_POST['product_price']);
    $product_quantity = trim($_POST['product_quantity']);
    $product_points = trim($_POST['product_points']);
    
    $product_points = (int) $product_points;
    
    // Use $_FILES to get the temporary filename of the uploaded image
    $product_image_tmp = $_FILES['image']['tmp_name'];

    // Check for file upload errors
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        feedback("File upload failed with error code: " . $_FILES['image']['error']);
        exit;  // Stop execution if there's a file upload error
    }

    $format = explode('.', $_FILES['image']['name']);
    $actualName = strtolower($format[0]);
    $actualFormat = strtolower($format[1]);
    $allowedFormats = ['jpg', 'png', 'jpeg', 'gif'];

    $image_name =  $actualName .'.' .$actualFormat;
    if (in_array($actualFormat, $allowedFormats)) {
        $location = '../../assets/img/product/' . $actualName . '.' . $actualFormat;

        $insert = $connection->prepare('INSERT INTO inventory (product_name, category_id, price, quantity, product_points, image) 
            VALUES (:product_name, :category_id, :price, :quantity, :points, :image)'); // Change to category_id
        $insert->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $insert->bindParam(':category_id', $category_id, PDO::PARAM_INT); // Change to category_id
        $insert->bindParam(':price', $product_price, PDO::PARAM_INT);
        $insert->bindParam(':quantity', $product_quantity, PDO::PARAM_INT);
        $insert->bindParam(':image', $image_name, PDO::PARAM_STR);
        $insert->bindParam(':points', $product_points, PDO::PARAM_INT);

        if ($insert->execute()) {
            // Use the correct variable name for move_uploaded_file
            if (move_uploaded_file($product_image_tmp, $location)) {
                echo "<script>window.location.href='" . FILEPATH . "/product/product_list.php';</script>";
            } else {
                feedback("Error moving uploaded file!");
            }
        } else {
            feedback("Error adding product!");
        }
    } else {
        feedback("Invalid file format!");
    }
} else {
    feedback("Button has not yet been clicked!");
}
?>
