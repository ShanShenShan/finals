<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->

<?php

// Query to select all data on the table that have admin role
$search = $connection->query("SELECT * FROM users WHERE role= 'customer' ");
$search->execute(); // executing the command

$customerlist = $search->fetchall(PDO::FETCH_OBJ); // fetching all of the data as an object

?>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="<?php echo "" . FILEPATH . ""; ?>/admin_index.php" class="logo">
                    <img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/logo.png" alt="">
                </a>
                <a href="../admin_index.php" class="logo-small">
                    <img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/logo-small.png" alt="">
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
                        <span class="user-img"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="<?php echo "" . FILEPATH . ""; ?>/auth/logout.php"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.php">Settings</a>
                    <a class="dropdown-item" href="<?php echo "" . FILEPATH . ""; ?>/auth/logout.php">Logout</a>
                </div>
            </div>

        </div>
        <!--SIDEBAR SECTION-->
        <?php require "../includes/sidebar.php"; ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Customers List</h4>
                        <h6>Manage your Customer</h6>
                    </div>
                    <div class="page-btn">
                        <a href="add_customer.php" class="btn btn-added"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/plus.svg" alt="img" class="me-1">Add Customers</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/search-white.svg" alt="img"></a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Customers ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Customize</th>
                                    </tr>
                                </thead>
                                <?php foreach ($customerlist as $customer) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                    <tbody>
                                        <tr>
                                            <td><?php echo $customer->id; ?></td>
                                            <td><?php echo $customer->name; ?></td>
                                            <td><?php echo $customer->email; ?></td>
                                            <td><?php echo $customer->role; ?></td>
                                            <td>
                                            <a class="me-3" data-bs-toggle="modal" data-bs-target="#editProductModal"onclick="update_account('<?php echo $customer->name; ?>', '<?php echo $customer->email; ?>', '<?php echo $customer->id; ?>')">
                                                <img src="<?php echo FILEPATH;?>/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                                <a data-bs-toggle="modal" onclick="delete_account(<?php echo $customer->id; ?>);" data-bs-target="#deleteProductModal" data-productid="<?php echo $customer->id; ?>">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/delete.svg" alt="Delete">
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