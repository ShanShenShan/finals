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

// Gathering data in category table
$search_category = $connection->query("SELECT * FROM category ");
$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

// Gathering data on inventory table
$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");
$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);

// Gathering data for DONUT CHART
// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');


$search = $connection->prepare("SELECT i.product_name, SUM(tp.o_quantity) as total_quantity
                                FROM transaction_products tp
                                JOIN inventory i ON tp.product_id = i.id
                                JOIN transaction_records tr ON tp.tran_id = tr.id
                                WHERE MONTH(tr.tr_date) = :currentMonth AND YEAR(tr.tr_date) = :currentYear
                                GROUP BY tp.product_id");


$search->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
$search->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);

$search->execute();

// Fetch the data
$salesData = $search->fetchAll(PDO::FETCH_ASSOC);

// If submit button has been clicked the below code will happen
if (isset($_POST['submit'])) {

    // fetch your data here
    // generate a syntax
    // fetch the result either OBJ or ASSOC
    

} else {
//getting data on transaction table
$transaction_search = $connection->query("SELECT * FROM transaction_records");
$transaction_search->execute();
$transaction_data =  $transaction_search->fetchAll(PDO::FETCH_OBJ);
}

//Displaying total number of customer 
$select_all_customeers = $connection->query("SELECT COUNT(*) FROM customers");
$select_all_customeers->execute();
$customer_Count = $select_all_customeers->fetchColumn();
//Displaying total number of employees 
$select_all_employee = $connection->query("SELECT COUNT(*) FROM employee");
$select_all_employee->execute();
$employee_Count = $select_all_employee->fetchColumn();
//Displaying total number of categories
$select_all_category = $connection->query("SELECT COUNT(*) FROM category");
$select_all_category->execute();
$category_Count = $select_all_category->fetchColumn();
//Displaying total number of products
$select_all_products = $connection->query("SELECT COUNT(*) FROM inventory");
$select_all_products->execute();
$products_Count = $select_all_products->fetchColumn();
// Displaying income
$select_all_value = $connection->query("SELECT SUM(total_amount) FROM transaction_records");
$select_all_value->execute();
$shop_income = $select_all_value->fetchColumn();
// Displaying exchange amount
$select_all_value = $connection->query("SELECT (SUM(cash_amount) - SUM(total_amount)) AS total_diff FROM transaction_records");
$select_all_value->execute();
$total_exchange = $select_all_value->fetchColumn();
// Displaying order quantity 
$select_all_value = $connection->query("SELECT SUM(o_quantity) FROM transaction_products");
$select_all_value->execute();
$total_order = $select_all_value->fetchColumn();
// Displaying order quantity 
$select_all_value = $connection->query("SELECT SUM(quantity) FROM inventory");
$select_all_value->execute();
$total_inventory = $select_all_value->fetchColumn();
//Selecting all data on the kiosk pending table
$retrieving_data = $connection->query("SELECT * FROM pending_order_kiosk");
$retrieving_data->execute();
$kiosk_data = $retrieving_data->fetchAll(PDO::FETCH_OBJ);
foreach ($kiosk_data as $data) {
    $order_id = $data->o_id;
    $customer_id = $data->customer_id;
    $product_id = $data->product_id;
}
?>

<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Left Header -->
            <div class="header-left active">
                <a href="admin_index.php" class="logo">
                    <img src="assets/img/logo1.png" alt="">
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
                                <?php foreach ($kiosk_data as $data):?>                   
                                <li class="notification-message">
                                    <a href="sales/pending_list.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Kiosk System send an order</span> <?php echo $data->o_id;?> <span class="noti-title">is the order number</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php endforeach;?>
                            </ul>
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
                                <li><a href="sales/sales_list.php">Sales List</a></li>
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
                                <li><a href="data/records.php">Records</a></li>
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
                                <h5> ₱<span class="counters" data-count="<?php echo $total_inventory;?>"></span></h5>
                                <h6>Total Inventory quantity</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5> ₱<span class="counters" data-count="<?php echo $shop_income;?>"> </span></h5>
                                <h6>Total Income</h6><wbr>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5> ₱<span class="counters" data-count="<?php echo $total_exchange;?>"></span></h5>
                                <h6>Total Exchange Amount</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₱<span class="counters" data-count="<?php echo $total_order;?>"></span></h5>
                                <h6>Total Order Amount</h6><wbr>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4><?php echo $customer_Count;?></h4>
                                <h5>Customers Loyalty Card</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4><?php echo $employee_Count;?></h4>
                                <h5>Employees</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4><?php echo $category_Count;?></h4>
                                <h5>Category</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4><?php echo $products_Count;?></h4>
                                <h5>Products</h5>
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
                                       <?php $rnMonth = date('F'); ?>
                                            <h4>Top Selling Products</h4>
                                            <h6>For the month of <?php echo $rnMonth ?></h6>
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
                                                            <a href="product/product_details.php?id=<?php echo $product->id;?>"><?php echo $product->product_name; ?></a>
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
                                        <a href="cata/records.php" class="dropdown-item">Records</a>
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
                                        <form action="admin_indeX.php" method="POST">
                                            <div class="row">
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" name="date" placeholder="Date">
                                                    </div>
                                                </div>
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" name="emp_id" placeholder="Employee id">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" name="customer_id" placeholder="Customer id">
                                                    </div>
                                                </div>

                                                <div class="col-lg col-sm-6 col-12 ">
                                                    <div class="form-group">
                                                        <input type="text" name="cash-tenderes" placeholder="Cash Tendered">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaction_data as $info) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>

                                            <td><?php echo $info->id; ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);"><?php echo $info->tr_date; ?></a>
                                            </td>
                                            <td><?php echo $info->emp_id ; ?></td>
                                            <td><?php echo $info->customer_id ; ?></td>
                                            <td><?php echo $info->total_amount; ?></td>
                                            <td><?php echo $info->cash_amount; ?></td>
                                            <td>
                                                <a class="me-3" href="sales/sales_detail.php?id=<?php echo  $info->customer_id; ?>">
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
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66ff66', '#ff9966',
                                            '#34e3fd', '#fce630', '#3B3BFF', '#A530FF', '#613191',
                                            '#FF7F50', '#4CAF50', '#FFD700', '#FF69B4', '#8A2BE2',
                                            '#20B2AA', '#FF4500', '#32CD32', '#8B008B', '#5F9EA0',
                                            '#FF1493', '#2E8B57', '#9932CC', '#00FF7F', '#4682B4',
                                            '#8B4513', '#00FFFF', '#DC143C', '#00CED1', '#00FA9A',
                                            '#191970', '#8B0000', '#7B68EE', '#FFFF00', '#98FB98',
                                            '#00BFFF', '#7CFC00', '#FF6347', '#FA8072', '#FFDAB9',
                                            '#556B2F', '#8B008B', '#008080', '#8B4513',
                                            '#FFA07A', '#2F4F4F', '#8B4513', '#20B2AA', '#D8BFD8',
                                            '#FF4500', '#808000', '#8A2BE2', '#00FF00', '#000080',
                                            '#FAEBD7', '#FFD700', '#8B4513', '#2E8B57', '#FF6347',
                                            '#FFD700', '#4682B4', '#008080', '#556B2F', '#8B4513'],
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