<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?>
<?php
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    
    $query = $connection->query("SELECT inventory.*, category.category_name
    FROM inventory
    JOIN category ON inventory.category_id = category.id
    WHERE inventory.id = $id");
    $query->execute();
    $product_details=$query->fetchAll(PDO::FETCH_OBJ);
    
    foreach($product_details as $product_info)
    {
        $product_name= $product_info->product_name;
        $category_name= $product_info->category_name;
        $product_quantity= $product_info->quantity;
        $product_points= $product_info->product_points;
        $product_image= $product_info->image;
        $product_price= $product_info->price;
        $product_description= $product_info->description;
        $product_id= $product_info->id;
    }
}

?>
<body>
<div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Details</h4>
                        <h6>Full details of a product</h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bar-code-view">
                                    <p>Bar code Not available</p>
                                    <a class="printimg">
                                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/printer.svg" alt="print">
                                    </a>
                                </div>
                                <div class="productdetails">
                                    <ul class="product-bar">
                                        <li>
                                            <h4>Product</h4>
                                            <h6><?php echo $product_name;?> </h6>
                                        </li>
                                        <li>
                                            <h4>Category</h4>
                                            <h6><?php echo $category_name;?></h6>
                                        </li>
                                        
                                        
                                        <li>
                                            <h4>Quantity</h4>
                                            <h6><?php echo $product_quantity;?></h6>
                                        </li>
                                       
                                        <li>
                                            <h4>Product Points</h4>
                                            <h6><?php echo $product_points;?></h6>
                                        </li>

                                        <li>
                                            <h4>Price</h4>
                                            <h6><?php echo $product_price;?></h6>
                                        </li>
                                        
                                        <li>
                                            <h4>Description
                                            <a data-bs-toggle="modal"data-bs-target="#editProductModal" class="me-3" onclick="Edit_Category('<?php echo $product_description;?>', '<?php echo $product_id; ?>')">
                                                    <img style="margin-left: 100px;" src="<?php echo FILEPATH; ?>/assets/img/icons/edit.svg" alt="img">
                                                </a>
                                            </h4>
                                            <h6><?php echo $product_description;?></h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="slider-product-details">
                                    <div class="owl-carousel owl-theme product-slide">
                                        <div class="slider-product">
                                            <img data-bs-target="#editProductModal" src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product_image;?>" alt="img">
                                            <h4><?php echo $product_image;?></h4>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing product -->
                    <form action="../process/product_crud/update_description.php" method="POST">
                        
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Product Description</label>
                            <input type="hidden" id="id" name="id">
                            <textarea id="description" name="description" class="form-control" rows="4" cols="50">                              
                            </textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update_description" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>
<script>
// php to html
function Edit_Category(description,id) 
            {
                $('#id').val(id);
                $('#description').val(description);
            }
</script>
</html>