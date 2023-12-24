<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?>

<?php
// If submit button has been clicked the below code will happen
if (isset($_POST['submit'])) {

    // Getting the user's input from the form html
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Searching the celected input and executing it
    $search = $connection->query("SELECT inventory.*, category.category_name
    FROM inventory
    JOIN category ON inventory.category_id = category.id
    WHERE product_name = '$name' OR category_name = '$category' OR price = $price;");
    $search->execute();
    $productlist = $search->fetchAll(PDO::FETCH_OBJ); // Fetch the results into an array

    $search_category = $connection->query("SELECT * FROM category ");

$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);
}
else{
    // Query to select all data on the table that have admin role
$search = $connection->query("SELECT inventory.*, category.category_name 
FROM inventory 
JOIN category ON inventory.category_id = category.id");


$search->execute();
$productlist = $search->fetchAll(PDO::FETCH_OBJ); // fetching all of the data as an object

$search_category = $connection->query("SELECT * FROM category ");

$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);
}



?>

<body>

    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product List</h4>
                        <h6>Manage your products</h6>
                    </div>
                    <div class="page-btn">
                        <a href="add_product.php" class="btn btn-added"><img src="<?php echo FILEPATH; ?>/assets/img/icons/plus.svg" alt="img" class="me-1">Add New Product</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/filter.svg" alt="img">
                                        <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/closes.svg" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="<?php echo FILEPATH; ?>/assets/img/icons/search-white.svg" alt="img"></a>
                                </div>
                            </div>
                        </div>
                        <!--Filtering option-->
                        <div class="card mb-0" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <form action="product_list.php" method="POST">
                                            <div class="row">
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <select class="select" name="name">
                                                            <option>Choose Product</option>
                                                            <?php foreach ($productlist as $product) : ?>
                                                                <option value="<?php echo $product->product_name; ?>"><?php echo $product->product_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <select class="select" name="category">
                                                            <option>Choose Category</option>
                                                            <?php foreach ($product_category as $product_category) : ?>
                                                                <option value="<?php echo $product_category->category_name; ?>"><?php echo $product_category->category_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg col-sm-6 col-12 ">
                                                    <div class="form-group">
                                                        <select class="select" name="price">
                                                            <option>Price</option>
                                                            <?php foreach ($product_price as $product) : ?>
                                                                <option value="<?php echo $product->price; ?>">₱<?php echo $product->price; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        
                                                        <button type="submit" name="submit" class="btn btn-filters ms-auto">
                                                            <img src="<?php echo FILEPATH; ?>/assets/img/icons/search-whites.svg" alt="img">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Table data of the products-->
                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Category </th>
                                        <th>price</th>
                                        <th>Qty</th>
                                        <th>Points</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productlist as $product) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td><?php echo $product->id; ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" alt="product">
                                                </a>
                                                <a href="javascript:void(0);"><?php echo $product->product_name; ?></a>
                                            </td>
                                            <td><?php echo $product->category_name; ?></td>
                                            <td>₱<?php echo $product->price; ?></td>
                                            <td><?php echo $product->quantity; ?></td>
                                            <td><?php echo $product->product_points; ?></td>

                                            <td>                                               
                                                <a class="me-3" onclick="openEditProductModal('<?php echo $product->id; ?>', '<?php echo $product->product_name; ?>', '<?php echo $product->category_id; ?>', '<?php echo $product->price; ?>', '<?php echo $product->quantity; ?>', '<?php echo $product->product_points; ?>')">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/edit.svg" alt="img">
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-productid="<?php echo $product->id; ?>">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/delete.svg" alt="Delete">
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CODE FOR THE POP-UP EDIT FORM -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing product -->
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId" name="editProductId">

                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="editProductName" required>
                        </div>

                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <select class="form-control" id="editCategoryName" name="editCategoryName" required>
                                <!-- The options will be populated via JSCRIPT below -->
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" name="editPrice" required>
                        </div>

                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="editQuantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="editPoints" class="form-label">Point Value</label>
                            <input type="number" class="form-control" id="editPoints" name="editPoints" required>
                        </div>

                        <div class="mb-3">
                            <label for="editImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="editImage" name="editImage" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="updateProduct()">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL FROM BOOTSRAP-->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="deleteProductLink" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>



    <!--DELETE PRODUCT JSCRIPT-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event to delete buttons
            document.querySelectorAll('a[data-bs-target="#deleteProductModal"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-productid');
                    // Set the href attribute of the delete link in the modal to include the product ID 
                    document.getElementById('deleteProductLink').href = "<?php echo FILEPATH; ?>/process/product_crud/delete_product.php?id=" + productId;
                });
            });
        });
    </script>


    <!--  FETCH CATEGORIES AND EDIT PRODUCT POPUP-->
    <script>
        // POPULATING THE CATEGORIES IN EDIT
        function populateCategoriesSelect(selectedCategory) {
            // Make an AJAX request to get categories from the server
            fetch('<?php echo "" . FILEPATH . "" ?>/process/product_crud/get_categories.php')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('editCategoryName');
                    select.innerHTML = "";

                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id; // Change to the category ID
                        option.text = category.category_name;

                        // Set the default value to the selected category
                        if (category.id === selectedCategory) {
                            option.selected = true;
                        }

                        select.appendChild(option);
                    });
                });
        }


        // OPENING THE EDIT PRODUCT MODAL AND SETTING CURRENT VALUES
        function openEditProductModal(id, name, category, price, quantity, product_points) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editProductName').value = name;

            // Call the populateCategoriesSelect function with the current category
            populateCategoriesSelect(category);

            document.getElementById('editPrice').value = price;
            document.getElementById('editQuantity').value = quantity;
            document.getElementById('editPoints').value = product_points;

            // Open the modal upon clicking edit icon
            $('#editProductModal').modal('show');
        }

        // FUNCTION TO UPDATE PRODUCT
        function updateProduct() {


            // Validate the form inputs
            const productName = document.getElementById('editProductName').value.trim();
            const price = document.getElementById('editPrice').value.trim();
            const quantity = document.getElementById('editQuantity').value.trim();
            const points = document.getElementById('editPoints').value.trim();



            // Check if any of the required fields are empty
            if (productName === '' || price === '' || quantity === '' || points === '') {
                alert('Please fill in all the required fields.');
                return;
            }


            // Use FormData to handle file uploads
            const formData = new FormData(document.getElementById('editProductForm'));

            // Make an AJAX request to update the product
            fetch('<?php echo "" . FILEPATH . "" ?>/process/product_crud/update_product.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        $('#editProductModal').modal('hide');

                        // Refresh the page
                        location.reload();
                    } else {
                        // Handle errors if needed
                        console.error(data.message);
                    }
                });
        }

        // Populate categories on page load
        window.addEventListener('load', function() {
            populateCategoriesSelect(); // Assuming there's no default category initially
        });
    </script>






    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>