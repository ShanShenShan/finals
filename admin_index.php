<?php require "includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->

<?php
// Query to select all data on the table that have admin role
$search = $connection->query("SELECT inventory.*, category.category_name 
    FROM inventory 
    JOIN category ON inventory.category_id = category.id
    ORDER BY inventory.id DESC
    LIMIT 4;
    ");


$search->execute();
$productlist = $search->fetchAll(PDO::FETCH_OBJ); // fetching all of the data as an object

$search_category = $connection->query("SELECT * FROM category ");

$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);

$search = $connection->query("SELECT i.product_name, SUM(po.o_quantity) as total_quantity
                             FROM pending_orders po
                             JOIN inventory i ON po.product_id = i.id
                             GROUP BY po.product_id");
$search->execute();

$salesData = $search->fetchAll(PDO::FETCH_ASSOC);

//getting data on transaction table
$transaction_search = $connection->query("SELECT * FROM transaction_records");
$transaction_search->execute();
$transaction_data =  $transaction_search->fetchAll(PDO::FETCH_OBJ);
?>

<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Left Header -->
            <div class="header-left active">
                <a href="admin_index.php" class="logo">
                    <img src="assets/img/logo.png" alt="">
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
                            <a class="dropdown-item logout pb-0" href="<?php echo FILEPATH; ?>/auth/logout.php"><img src="<?php echo FILEPATH; ?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Mobile User Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="<?php echo "" . FILEPATH . ""; ?>/auth/logout.php">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="admin_index.php"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/product.svg" alt="img"><span>
                                    Product</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="product/add_product.php">Add Product</a></li>
                                <li><a href="product/add_category.php">Add Category</a></li>
                                <li><a href="product/product_list.php">Product List</a></li>
                                <li><a href="product/category_list.php">Category List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="saleslist.php">Sales List</a></li>
                                <li><a href="sales/pending_list.php">Pending Orders</a></li>
                                <li><a href="sales/pos.php">POS</a></li>

                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
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
                            <a href="javascript:void(0);"><img src="<?php echo "" . FILEPATH . ""; ?>/assets/img/icons/time.svg" alt="img"><span>
                                    Data</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="inventoryreport.php">Inventory</a></li>
                                <li><a href="records.php">Records</a></li>
                                <li><a href="data/graph.php">Graphs</a></li>
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
                                <h5> ₱<span class="counters" data-count="307144.00"> 307,144.00</span></h5>
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
                                <h5> ₱<span class="counters" data-count="4385.00"> 4,385.00</span></h5>
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
                                <h5> ₱<span class="counters" data-count="385656.50"> 385,656.50</span></h5>
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
                                <h5>₱<span class="counters" data-count="40000.00"> 400.00</span></h5>
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

                <div class="container-fluid">
                    <div class="row">
                        <!-- Graph -->
                        <div class="col-md-6" style="width: 700px;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header">
                                        <div class="page-title">
                                            <h4>Graphs</h4>
                                            <h6>Visual Sales Data</h6>
                                        </div>
                                    </div>
                                    <div style="width: 100%; height: 300px;">
                                        <?php if (count($salesData) > 0) : ?>
                                            <canvas id="donutChartContainer" style="margin-left: 20%;"></canvas>
                                        <?php else : ?>
                                            <p>No data found</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-sm-12 col-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Recently Added Products</h4>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a href="product/product_list.php" class="dropdown-item">Product List</a>
                                            </li>
                                            <li>
                                                <a href="product/add_product.php" class="dropdown-item">Product Add</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive dataview">
                                        <table class="table datatable ">
                                            <thead>
                                                <tr>
                                                    <th>Sno</th>
                                                    <th>Products</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($productlist as $product) : ?>
                                                    <tr>
                                                        <td><?php echo $product->id; ?></td>
                                                        <td class="productimgname">
                                                            <a href="productlist.html" class="product-img">
                                                                <img src="assets/img/product/<?php echo $product->image; ?>" alt="product">
                                                            </a>
                                                            <a href="productlist.html"><?php echo $product->product_name; ?></a>
                                                        </td>
                                                        <td>₱<?php echo $product->price; ?></td>
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

                <!--Transaction section-->
                <div class="card">
                    <div class="card-body">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-0">Transaction list</h4>
                                <h6>Manage your transaction history</h6>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="product/product_list.php" class="dropdown-item">Product List</a>
                                    </li>
                                    <li>
                                        <a href="product/add_product.php" class="dropdown-item">Product Add</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <br>
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
                        <!--Filtering option-->
                        <div class="card mb-0" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <form action="product_list.php" method="POST">
                                            <div class="row">
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <select class="select" name="name">
                                                            <option>Choose Product</option>
                                                            <?php foreach ($productlist as $product) : ?>
                                                                <option value="<?php echo $product->product_name; ?>"><?php echo $product->product_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <select class="select" name="category">
                                                            <option>Choose Category</option>
                                                            <?php foreach ($product_category as $product_category) : ?>
                                                                <option value="<?php echo $product_category->category_name; ?>"><?php echo $product_category->category_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg col-sm-6 col-12 ">
                                                    <div class="form-group">
                                                        <select class="select" name="price">
                                                            <option>Price</option>
                                                            <?php foreach ($product_price as $product) : ?>
                                                                <option value="<?php echo $product->price; ?>">₱<?php echo $product->price; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-sm-6 col-12">
                                                    <div class="form-group">

                                                        <button type="submit" name="submit" class="btn btn-filters ms-auto">
                                                            <img src="<?php echo FILEPATH; ?>/assets/img/icons/search-whites.svg" alt="img">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Table data of the products-->
                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Transaction date</th>
                                        <th>Employee Id </th>
                                        <th>Cutomer Id</th>
                                        <th>Total amount</th>
                                        <th>Cash amount</th>
                                        <th>Pts Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaction_data as $info) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>

                                            <td><?php echo $info->id; ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);"><?php echo $info->	tr_date; ?></a>
                                            </td>
                                            <td><?php echo $info->emp_id ; ?></td>
                                            <td>₱<?php echo $info->customer_id ; ?></td>
                                            <td><?php echo $info->total_amount; ?></td>
                                            <td><?php echo $info->cash_amount; ?></td>
                                            <td><?php echo $info->pts_added; ?></td>
                                            <td>
                                                <a class="me-3" href="product_details.php?id=<?php echo  $info->id; ?>">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/eye.svg" alt="img">
                                                </a>
                                            </td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (count($salesData) > 0) : ?>
            var donutChartData = {
                labels: <?php echo json_encode(array_column($salesData, 'product_name')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($salesData, 'total_quantity')); ?>,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#66ff66', '#ff9966',
                        '#34e3fd', '#fce630', '#3B3BFF', '#A530FF', '#613191'
                    ],
                }],
            };

            // Create the donut chart
            var donutChartContext = document.getElementById("donutChartContainer").getContext("2d");
            var donutChart = new Chart(donutChartContext, {
                type: 'doughnut',
                data: donutChartData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Donut Sales Count Graph',
                    },
                    legend: {
                        display: true,
                        position: 'bottom', // You can change the position if needed
                        labels: {
                            padding: 30, // Adjust the padding to create more space between legend items
                        },
                    },
                },
            });
        <?php endif; ?>
    });
</script>

</html>