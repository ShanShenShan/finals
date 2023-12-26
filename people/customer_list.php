<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php

// Query to select all data on the table that have admin role
$search = $connection->query("SELECT * FROM users WHERE role= 'customer' ");
$search->execute(); // executing the command

$customerlist = $search->fetchall(PDO::FETCH_OBJ); // fetching all of the data as an object

?>

<body>

<div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Customer List</h4>
                    <h6>Manage your Customer list</h6>
                </div>
                <div class="page-btn">
                    <a href="add_customer.php" class="btn btn-added"><img src="<?php echo FILEPATH; ?>/assets/img/icons/plus.svg" alt="img" class="me-1">Add New customer</a>
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
                                
                            </div>
                        </div>
                    </div>
                    <!--Table data of the products-->
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>Admin id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customerlist as $customer) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                    <tr>
                                        <td><?php echo $customer->id; ?></td>
                                        <td><?php echo $customer->name; ?></td>
                                        <td><?php echo $customer->email; ?></td>
                                        <td><?php echo $customer->role; ?></td>

                                        <td>
                                            <a class="me-3" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="update_account('<?php echo $customer->name; ?>', '<?php echo $customer->email; ?>', '<?php echo $customer->id; ?>')">
                                                <img src="<?php echo FILEPATH; ?>/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a data-bs-toggle="modal" onclick="delete_account(<?php echo $customer->id; ?>);" data-bs-target="#deleteProductModal" data-productid="<?php echo $customer->id; ?>">
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
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Customer list</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing product -->
                <form action="../process/people_crud/update.php" method="POST">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                        <p style="margin-top: 10px;"><span style="font-weight: bold">Notes: </span>Don't change the domain name of email</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-submit me-2" id="position-top-end" name="update_customer_button">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- DELETE CONFIRMATION MODAL FROM BOOTSRAP-->
        <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <form action="../process/people_crud/delete.php" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this Customer account?
                            <input type="hidden" id="id_delete" name="id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete_account_customer" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function delete_account(id) 
            {
                $('#id_delete').val(id);
            }
            function update_account(name, email, id) 
            {
                $('#id').val(id);
                $('#name').val(name);
                $('#email').val(email);
            }
        </script>

        <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>