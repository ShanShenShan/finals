add_product.php
<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php

$search = $connection->query("SELECT * FROM category");
$search->execute();

$categorydata = $search->fetchAll(PDO::FETCH_OBJ);

//if(isset)

?>

<body>

    <div class="main-wrapper">

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

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Product Image</label>
                                        <div class="image-upload">
                                            <input type="file" name="image">
                                            <div class="image-uploads">
                                                <img src="<?php echo FILEPATH;?>/assets/img/icons/upload.svg" alt="img">
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