<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?>

<?php
if(isset($_POST['submit']))
{

// Getting the user's input from the form html
$category = $_POST['category'];

// Prepare a statement to select data based on the category input
$stmt = $connection->prepare("SELECT * FROM category WHERE category_name = :category");
$stmt->bindParam(':category', $category);
$stmt->execute();

$categorylist = $search->fetchall(PDO::FETCH_OBJ); // fetching all of the data as an object
}else{
    // Query to select all data on the table that have admin role
$search = $connection->query("SELECT * FROM category");
$search->execute(); // executing the command

$categorylist = $search->fetchall(PDO::FETCH_OBJ); // fetching all of the data as an object
}


?>

<body>

    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Category List</h4>
                        <h6>Manage your products</h6>
                    </div>
                    <div class="page-btn">
                        <a href="add_category.php" class="btn btn-added"><img src="<?php echo FILEPATH; ?>/assets/img/icons/plus.svg" alt="img" class="me-1">Add New Category</a>
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
                                        <form action="category_list.php" method="POST">
                                            <div class="row">
                                               
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <select class="select" name="category">
                                                            <option value=" ">Choose Category</option>
                                                            <?php foreach ($categorylist as $product_category) : ?>
                                                                <option value="<?php echo $product_category->category_name; ?>"><?php echo $product_category->category_name; ?></option>
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
                                        <th>Id</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorylist as $category) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>
                                            <td><?php echo $category->id; ?></td>
                                            
                                            <td><?php echo $category->category_name; ?></td>


                                            <td>
                                                <a class="me-3" href="product-details.html">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/eye.svg" alt="img">
                                                </a>
                                                <a class="me-3" data-bs-target="#editCategoryModal"onclick="openEditProductModal('<?php echo $category->id; ?>', '<?php echo $category->category_name; ?>')">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/edit.svg" alt="img">
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-productid="<?php echo $category->id; ?>">
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





        <!-- CODE FOR THE POP-UP EDIT FORM -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for editing category -->
                        <form id="editCategoryForm">
                            <input type="hidden" id="editCategoryId" name="editCategoryId">

                            <div class="mb-3">
                                <label for="editCategoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="editCategoryName" name="editCategoryName" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="updateCategory()">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE CONFIRMATION MODAL FROM BOOTSRAP-->
        <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="../process/product_crud/delete_categories.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel">Delete category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to remove this category?
                            <input type="hidden" id="id_delete" name="id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete_category" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            // OPENING THE EDIT Category MODAL AND SETTING CURRENT VALUES
            function openEditCategoryModal(id, category_name) {
                document.getElementById('editCategoryId').value = id;
                document.getElementById('editCategoryName').value = category_name;


                // Open the modal upon clicking edit icon
                $('#editCategoryModal').modal('show');
            }
            function delete_category(id)
            {
                $('#id_delete').val(id);
            }
            function updateCategory() {
                // Validate the form inputs
                const categoryId = document.getElementById('editCategoryId').value.trim();
                const categoryName = document.getElementById('editCategoryName').value.trim();

                // Check if any of the required fields are empty
                if (categoryId === '' || categoryName === '') {
                    alert('Please fill in all the required fields.');
                    return;
                }

                // Make an AJAX request to update the Category
                fetch('<?php echo "" . FILEPATH . "" ?>/process/product_crud/update_category.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `editCategoryId=${encodeURIComponent(categoryId)}&editCategoryName=${encodeURIComponent(categoryName)}`,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            $('#editCategoryModal').modal('hide');

                            // Refresh the page or update UI as needed
                            location.reload();
                        } else {
                            // Display an error message to the user
                            alert('Error updating category: ' + data.message);
                        }
                    })
                    .catch(error => {
                        // Handle network or unexpected errors
                        console.error('Error:', error);
                        alert('An unexpected error occurred. Please try again.');
                    });
            }
        </script>


        <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>