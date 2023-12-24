<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->

<?php
    
    // Query to select all data on the table that have admin role
    $search = $connection->query("SELECT inventory.*, category.category_name 
                              FROM inventory 
                              JOIN category ON inventory.category_id = category.id");

$search->execute();
$productlist = $search->fetchAll(PDO::FETCH_OBJ);
 // fetching all of the data as an object
?>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="<?php echo"".FILEPATH."";?>/admin_index.php" class="logo">
                    <img src="<?php echo"".FILEPATH."";?>/assets/img/logo.png" alt="">
                </a>
                <a href="admin_index.php" class="logo-small">
                    <img src="<?php echo"".FILEPATH."";?>/assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!--PROFILE SECTION-->
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="<?php echo"".FILEPATH."";?>/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo"".FILEPATH."";?>/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="<?php echo"".FILEPATH."";?>/auth/logout.php"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.php">Settings</a>
                    <a class="dropdown-item" href="<?php echo"".FILEPATH."";?>/auth/logout.php">Logout</a>
                </div>
            </div>

        </div>

        <?php require "../includes/sidebar.php"; ?>

        <div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>Manage your Product</h6>
            </div>
            <div class="page-btn">
                <a href="add_product.php" class="btn btn-added"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/plus.svg" alt="img" class="me-1">Add Product</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product ID</th>
                                <th>Product name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Point Value</th>
                                <th>Customize</th>
                            </tr>
                        </thead>
                        <?php foreach($productlist as $product) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                        <tbody>
                                    <tr>
                                        <td><img style="height: 60px; width: 60px; margin-left: 15%;" src="<?php echo FILEPATH;?>/assets/img/product/<?php echo $product->image;?>"></td>
                                        <td><?php echo $product->id;?></td>
                                        <td><?php echo $product->product_name;?></td>
                                        <td><?php echo $product->category_name;?></td>
                                        <td><?php echo $product->price;?></td>
                                        <td><?php echo $product->quantity;?></td>
                                        <td><?php echo $product->product_points;?></td>
                                        <!--buttons for the edit and delete, also fetches the current values-->
                                        <td>
                                            <!--setting default values to the edit pop up-->
                                            <a class="me-3" onclick="openEditProductModal('<?php echo $product->id; ?>', '<?php echo $product->product_name; ?>', '<?php echo $product->category_id; ?>', '<?php echo $product->price; ?>', '<?php echo $product->quantity; ?>', '<?php echo $product->product_points; ?>')">
                                                <img src="<?php echo FILEPATH;?>/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-productid="<?php echo $product->id; ?>">
                                                <img src="<?php echo FILEPATH;?>/assets/img/icons/delete.svg" alt="Delete">
                                            </a>
                                        </td>

                                    </tr>                       
                        </tbody>
                        <?php endforeach; ?>
                    </table>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Attach click event to delete buttons
        document.querySelectorAll('a[data-bs-target="#deleteProductModal"]').forEach(function (button) {
            button.addEventListener('click', function () {
                var productId = this.getAttribute('data-productid');
                // Set the href attribute of the delete link in the modal to include the product ID 
                document.getElementById('deleteProductLink').href = "<?php echo FILEPATH;?>/process/product_crud/delete_product.php?id=" + productId;
            });
        });
    });
</script>


<!--  FETCH CATEGORIES AND EDIT PRODUCT POPUP-->
<script>
    // POPULATING THE CATEGORIES IN EDIT
    function populateCategoriesSelect(selectedCategory) {
    // Make an AJAX request to get categories from the server
    fetch('<?php echo "".FILEPATH.""?>/process/get_categories.php')
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
    function openEditProductModal(id, name, category, price, quantity,product_points) {
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
        if (productName === '' || price === '' || quantity === '' || points=== '') {
            alert('Please fill in all the required fields.');
            return;
        }


        // Use FormData to handle file uploads
        const formData = new FormData(document.getElementById('editProductForm'));

        // Make an AJAX request to update the product
        fetch('<?php echo "".FILEPATH.""?>/process/product_crud/update_product.php', {
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
    window.addEventListener('load', function () {
        populateCategoriesSelect(); // Assuming there's no default category initially
    });
</script>






<?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>