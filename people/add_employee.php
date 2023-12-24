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
                        <h4>Add an Employee</h4>
                        <h6>Create new employee account</h6>
                    </div>
                </div>

                <form action="../auth/register.php" method="POST">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Employee Name</label>
                                        <input type="text" name="name" placeholder="Fullname">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Employee Email address</label>
                                        <input type="text" name="email" placeholder="email address @employee.com">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="pass-group">
                                        <input type="password" name="password" class="pass-input">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <button class="btn btn-submit me-2" id="position-top-end" name="register-button">Submit</button>
                                    <a href="<?php echo "".FILEPATH."/admin_index";?>.php" class="btn btn-cancel">Cancel</a> 
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