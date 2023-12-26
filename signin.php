<?php require "includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="assets/img/logo.png" alt="img">
                        </div>
                        <div class="login-userheading">
                            <h3>Sign in</h3>
                        </div>

                        <form action="auth/login.php" method="POST">
                            
                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="text" name="email" placeholder="Enter Email" >
                                    <img src="assets/img/icons/users1.svg" alt="img">
                                </div>
                            </div>

                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="pass-input" placeholder="Enter Password" >
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>

                            <div class="form-login">
                                <input type="submit" class="btn btn-login" name="signin-button" value="Submit">
                            </div>
                        </form>

                        <div class="signinform text-center">
                            <h4>Forgot password? <a href="recover.php" class="hover-a">Recover</a> <a href="xtreme_recovery.php"><i style="margin-left: 5px;" class="fa fa-key" aria-hidden="true"></i></a></h4>
                            
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