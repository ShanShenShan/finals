<?php require "../../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->

<?php 

$search=$connection->query("SELECT * FROM category");
$search->execute();
$category_list=$search->fetchAll(PDO::FETCH_OBJ);

$product_search=$connection->query("SELECT * FROM inventory");
$product_search->execute();
$product_list=$product_search->fetchAll(PDO::FETCH_OBJ);
?>
<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrappers">
        <div class="header">

            <div class="header-left border-0 ">
                <a href="../employee_index.php" class="logo">
                    <img src="<?php echo FILEPATH;?>/assets/img/logo.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="<?php echo FILEPATH;?>/assets/img/logo-small.png" alt="">
                </a>
            </div>


            <ul class="nav user-menu">

                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="<?php echo FILEPATH;?>/assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill">4</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH;?>/assets/img/profiles/avatar-02.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH;?>/assets/img/profiles/avatar-03.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH;?>/assets/img/profiles/avatar-06.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH;?>/assets/img/profiles/avatar-17.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH;?>/assets/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="<?php echo FILEPATH;?>/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo FILEPATH;?>/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.html"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> My Profile</a>
                            <a class="dropdown-item" href="generalsettings.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings me-2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html"><img src="<?php echo FILEPATH;?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>
        <div class="page-wrapper ms-0">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 tabs_wrapper">
                        <div class="page-header ">
                            <div class="page-title">
                                <h4>Categories</h4>
                                <h6>Manage your purchases</h6>
                            </div>
                        </div>
                        <ul class=" tabs owl-carousel owl-theme owl-product  border-0 ">
                        <!--displaying categories-->
                        <?php foreach($category_list as $categorylistings): ?>
                            <li id="<?php echo$categorylistings->category_name;?>">
                                <a class="product-details">
                                    <img src="<?php echo FILEPATH;?>/assets/img/product/product67.png" alt="img">
                                    <h6><?php echo $categorylistings->category_name;?></h6>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <div class="tabs_container">
                            <!--foreach-->
                            <?php foreach($product_list as $productlistings):?>
                            <div class="tab_content" data-tab="<?php echo $productlistings->category_name?>">
                                <div class="row">

                                    <div class="col-lg-3 col-sm-6 d-flex ">
                                        <div class="productset flex-fill">
                                            <div class="productsetimg">
                                                <a href="" data-bs-toggle="modal" data-bs-target="#ShowModal1"> <img src="<?php echo FILEPATH;?>/assets/img/product/<?php echo $productlistings->image;?>" alt="img"></a>
                                                <h6><?php echo $productlistings->quantity?></h6>
                                            </div>
                                            <div class="productsetcontent">
                                                <h5><?php echo $productlistings->category_name?></h5>
                                                <h4><?php echo $productlistings->product_name?></h4>
                                                <h6><?php echo $productlistings->price?></h6>
                                            </div>
                                        </div>
                                    </div>
                                                        
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 ">
                        <div class="order-list">
                            <div class="orderid">
                                <h4>Order List</h4>
                                <h5>Transaction id : #65565</h5>
                            </div>

                        </div>
                        <div class="card card-order">

                            <div class="card-body pt-0">
                                <div class="totalitem">
                                    <h4>Total items : 4</h4>
                                    <a href="javascript:void(0);">Clear all</a>
                                </div>
                                <div class="product-table">
                                    <!--foreach loop-->
                                    <ul class="product-lists">
                                        <li>
                                            <div class="productimg">
                                                <div class="productimgs">
                                                    <img src="<?php echo FILEPATH;?>/assets/img/product/product30.jpg" alt="img">
                                                </div>
                                                <div class="productcontet">
                                                    <h4>Pineapple
                                                        <a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="<?php echo FILEPATH;?>/assets/img/icons/edit-5.svg" alt="img"></a>
                                                    </h4>
                                                    <div class="productlinkset">
                                                        <h5>PT001</h5>
                                                    </div>
                                                    <div class="increment-decrement">
                                                        <div class="input-groups">
                                                            <input type="button" value="-" class="button-minus dec button">
                                                            <input type="text" name="child" value="0" class="quantity-field">
                                                            <input type="button" value="+" class="button-plus inc button ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>3000.00 </li>
                                        <li><a class="confirm-text" href="javascript:void(0);"><img src="<?php echo FILEPATH;?>/assets/img/icons/delete-2.svg" alt="img"></a></li>
                                    </ul>
                                    <!--foreach loop--> <!--function display of total items-->
                                </div>
                            </div>
                            <div class="split-card">
                            </div>
                            <div class="card-body pt-0 pb-2">
                                <div class="setvalue">
                                    <ul>
                                        <li>
                                            <h5>Subtotal </h5>
                                            <h6>55.00$</h6>
                                        </li>
                                        <li class="total-value">
                                            <h5>Total </h5>
                                            <h6>60.00$</h6>
                                        </li>
                                    </ul>
                                </div>

                                <button class="btn-totallabel" class="btn btn-submit me-2" id="position-top-end" name="checkout-button">
                                    <h5>Checkout</h5>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--edit Order list Section-->
    <div class="modal fade" id="ShowModal1" tabindex="-1" aria-labelledby="ShowModal1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order List edit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" style=" display: block; margin: 0 auto; border: none; color: black;
                                         background-color: transparent; font-weight: bold; text-align: center; font-size: 18px" name="modal_prod_name1" id="modal_prod_name1" readonly>
                        </div>
                        <label>Quantity</label>


                        <div class="row">
                            <div class="increment-decrement col-4">
                                <div class="input-groups">
                                    <input type="button" onclick="Minus_button1()" value="-" class="button-minus  button">
                                    <input type="text" id="current_quantity1" name="current_quantity1" value="1" class="quantity-field " readonly>
                                    <input type="button" onclick="Add_button1()" value="+" class="button-plus button ">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" id="modal_price1" name="modal_price1" readonly>
                                    <input type="hidden" id="modal_prod_id1" name="modal_prod_id1">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Total Price</label>
                                    <input type="text" id="modal_totalPrice1" name="modal_totalPrice1" readonly>
                                    <input type="hidden" id="modal_prod_category1" name="modal_prod_category1">
                                </div>
                            </div>
                        </div>
                </div>
                <div style="justify-content: end !important;" class="modal-footer">
                    <label>Availability:</label>
                    <input style="margin-right: 383px; text-align: center; width: 30px;" type="text" id="modal_prod_quantity1" name="modal_prod_quantity1">
                    <button type="button" onclick="Default()" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-submit" name="submit-button-edit">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php require "../../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>