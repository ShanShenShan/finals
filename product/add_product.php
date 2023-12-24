add_product.php
<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php

$search = $connection->query("SELECT * FROM category");
$search->execute();

$categorydata = $search->fetchAll(PDO::FETCH_OBJ);



?>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="<?php echo "" . FILEPATH . ""; ?>/admin_index.php" class="logo">
                    <img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/logo.png" alt="">
                </a>
                <a href="admin_index.php" class="logo-small">
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

<?php require "../includes/sidebar.php"; ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Add Product</h4>
                        <h6>Add new type of product</h6>
                    </div>
                </div>

                <form action="../process/product_crud/product_registration.php" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category</label>

                                        <select style="width: 270px; height: 40px;padding: 8px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;" name="category_id">
                                            <option value="">Choose Category</option>
                                            <?php foreach ($categorydata as $data) : ?>
                                                <option value="<?php echo $data->id; ?>"><?php echo $data->category_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="text" name="product_quantity">

                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="product_price">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Product Points</label>
                                        <input type="text" name="product_points">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Product Image</label>
                                        <div class="image-upload">
                                            <input type="file" name="image">
                                            <div class="image-uploads">
                                                <img src="<?php echo FILEPATH; ?>/assets/img/icons/upload.svg" alt="img">
                                                <h4>Drag and drop a file to upload</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-12">
                                    <button class="btn btn-submit me-2" id="position-top-end" name="submit-button">Submit</button>
                                    <a href="<?php echo "" . FILEPATH . "/admin_index"; ?>.php" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>