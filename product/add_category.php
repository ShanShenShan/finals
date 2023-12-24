<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<body>

    <div class="main-wrapper">

        <div class="page-wrapper">
        <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Add Category</h4>
                        <h6>Create new product Category</h6>
                    </div>
                </div>

               <!--Adding category-->
                <form action="../process/product_crud/category_registration.php" method="POST">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" name="category">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                <button class="btn btn-submit me-2" name="submit-button" id="position-top-end">Submit</button>
                                
                                    
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