<?php require "includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php
    // Query to select all data on the table that have admin role
    $search = $connection->query("SELECT inventory.*, category.category_name 
    FROM inventory 
    JOIN category ON inventory.category_id = category.id
    ORDER BY inventory.id DESC
    LIMIT 5;
    ");


    $search->execute();
    $productlist = $search->fetchAll(PDO::FETCH_OBJ); // fetching all of the data as an object

    $search_category = $connection->query("SELECT * FROM category ");

    $search_category->execute();
    $product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

    $search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

    $search_price->execute();
    $product_price = $search_price->fetchAll(PDO::FETCH_OBJ);

?>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Left Header -->
            <div class="header-left active">
                <a href="admin_index.php" class="logo">
                    <img src="assets/img/dlogo.png" alt="">
                </a>
                <a href="admin_index.php" class="logo-small">
                    <img src="assets/img/logo-small1.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);"></a>
            </div>

            <!-- User Menu -->
            <ul class="nav user-menu">

                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill">4</span>
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
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-02.jpg">
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
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-03.jpg">
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
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-06.jpg">
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
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-17.jpg">
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
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-13.jpg">
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
                        <span class="user-img"><img src="<?php echo FILEPATH; ?>/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo FILEPATH; ?>/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="users_section/profile.php"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> My Profile</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="<?php echo FILEPATH;?>/auth/logout.php"><img src="<?php echo FILEPATH; ?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Mobile User Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="<?php echo"".FILEPATH."";?>/auth/logout.php">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="admin_index.php"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/product.svg" alt="img"><span>
                                    Product</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="product/add_product.php">Add Product</a></li>
                                <li><a href="product/add_category.php">Add Category</a></li>
                                <li><a href="product/product_list.php">Product List</a></li>
                                <li><a href="product/category_list.php">Category List</a></li>                              
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="saleslist.php">Sales List</a></li>
                                <li><a href="sales/pending_list.php">Pending Orders</a></li>
                                <li><a href="sales/pos.php">POS</a></li>

                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
                            <ul>
                            <li><a href="people/add_customer.php">Add Customer </a></li>
                                <li><a href="people/add_employee.php">Add Employee </a></li>
                                <li><a href="people/add_admin.php">Add Admin </a></li>
                                <li><a href="people/customer_list.php">Customer List</a></li>
                                <li><a href="people/employee_list.php">Employee List</a></li>
                                <li><a href="people/admin_list.php">Admin List</a></li>                                  
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/time.svg" alt="img"><span>
                                    Data</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="inventoryreport.php">Inventory</a></li>
                                <li><a href="records.php">Records</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>$<span class="counters" data-count="307144.00">$307,144.00</span></h5>
                                <h6>Total Purchase Due</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>$<span class="counters" data-count="4385.00">$4,385.00</span></h5>
                                <h6>Total Sales Due</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>$<span class="counters" data-count="385656.50">385,656.50</span></h5>
                                <h6>Total Sale Amount</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>$<span class="counters" data-count="40000.00">400.00</span></h5>
                                <h6>Total Sale Amount</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4>100</h4>
                                <h5>Customers</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4>100</h4>
                                <h5>Suppliers</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>100</h4>
                                <h5>Purchase Invoice</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4>105</h4>
                                <h5>Sales Invoice</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Products -->
                <div class="card">
                    <div class="card-body"><div class="page-header">
                    <div class="page-title">
                        <h4>Recently Added Products</h4>
                        <h6>Manage your products</h6>
                    </div>
                </div>
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
                        <!--Table data of the products-->
                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>

                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Category </th>
                                        <th>price</th>
                                        <th>Qty</th>
                                        <th>Points</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productlist as $product) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>

                                            <td><?php echo $product->id; ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" alt="product">
                                                </a>
                                                <a href="javascript:void(0);"><?php echo $product->product_name; ?></a>
                                            </td>
                                            <td><?php echo $product->category_name; ?></td>
                                            <td>₱<?php echo $product->price; ?></td>
                                            <td><?php echo $product->quantity; ?></td>
                                            <td><?php echo $product->product_points; ?></td>                                           
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require "includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>
