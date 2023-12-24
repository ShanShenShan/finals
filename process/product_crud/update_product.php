<?php
require "../../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["editProductId"];
    $productName = $_POST["editProductName"];
    $categoryName = $_POST["editCategoryName"];
    $price = $_POST["editPrice"];
    $quantity = $_POST["editQuantity"];
    $points = $_POST["editPoints"];

    // Handle image upload if a file is selected
    if ($_FILES["editImage"]["name"] != "") {
        $imageFileName = $_FILES["editImage"]["name"];
        $imageFilePath = "../../assets/img/product/" . $imageFileName;

        // Move uploaded file to the specified directory
        move_uploaded_file($_FILES["editImage"]["tmp_name"], $imageFilePath);
    }

    // Update the product in the database
    $updateQuery = $connection->prepare("UPDATE inventory SET 
                                    product_name = :productName, 
                                    category_id = :categoryId, 
                                    price = :price, 
                                    quantity = :quantity,
                                    product_points = :points,
                                    image = :image
                                    WHERE id = :productId");

    $updateQuery->bindParam(":productId", $productId);
    $updateQuery->bindParam(":productName", $productName);
    $updateQuery->bindParam(":categoryId", $categoryName);
    $updateQuery->bindParam(":price", $price);
    $updateQuery->bindParam(":quantity", $quantity);
    $updateQuery->bindParam(":points", $points);

    if (isset($imageFilePath)) {
        $updateQuery->bindParam(":image", $imageFileName);
    } else {
        // If no new image is uploaded, set the image column to its current value
        $currentImage = getCurrentImage($productId, $connection);
        $updateQuery->bindParam(":image", $currentImage);
    }

    $updateQuery->execute();

    // Return success message as JSON
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} else {
    // Return error message as JSON
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

// Function to get the current image value from the database
function getCurrentImage($productId, $connection) {
    $selectQuery = $connection->prepare("SELECT image FROM inventory WHERE id = :productId");
    $selectQuery->bindParam(":productId", $productId);
    $selectQuery->execute();
    $result = $selectQuery->fetch(PDO::FETCH_ASSOC);
    return $result['image'];
}
?>
