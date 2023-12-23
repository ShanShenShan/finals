<?php
require "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST["editCategoryId"];
    $categoryName = $_POST["editCategoryName"];

    // Update the Category in the database
    $updateQuery = $connection->prepare("UPDATE category SET 
                                        category_name = :categoryName
                                        WHERE id = :categoryId");

    $updateQuery->bindParam(":categoryId", $categoryId);
    $updateQuery->bindParam(":categoryName", $categoryName);

    $updateQuery->execute();

    // Return success message as JSON
    echo json_encode(["success" => true, "message" => "Category updated successfully"]);
} else {
    // Return error message as JSON
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

?>
