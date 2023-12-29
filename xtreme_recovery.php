<?php require "includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                           <a href="signin.php"><img style="margin-left: 200px;" src="assets/img/logo2.png" alt="img"></a> 
                        </div>
                        <div class="login-userheading">
                            <h3>Recover your account</h3>
                        </div>
                        <form action="auth/recovery.php" method="POST">                           
                        <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="text" name="email" placeholder="Enter valid email" >
                                    <img src="assets/img/icons/users1.svg" alt="img">
                                </div>                               
                            </div>

                            <div class="form-login">
                                <input type="submit" class="btn btn-login" name="x_recovery-button" value="Submit">
                            </div>
                        </form>

                        <div class="signinform text-center">
                            <h4>Already have an account? <a href="signin.php" class="hover-a">Sign in</a></h4>
                            
                        </div>
                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/login.png" alt="img">
                </div>
            </div>
        </div>
    </div>
    <?php require "includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>