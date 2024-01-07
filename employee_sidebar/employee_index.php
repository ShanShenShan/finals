<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php
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

//getting data on transaction table
$transaction_search = $connection->query("SELECT * FROM transaction_records");
$transaction_search->execute();
$transaction_data =  $transaction_search->fetchAll(PDO::FETCH_OBJ);

//Selecting all data on the kiosk pending table
$retrieving_data = $connection->query("SELECT * FROM pending_order_kiosk GROUP BY o_id;");
$retrieving_data->execute();
$kiosk_data = $retrieving_data->fetchAll(PDO::FETCH_OBJ);

//Selecting all data on the kiosk pending table
$retrieving_data = $connection->query("SELECT COUNT(*)
FROM (
    SELECT o_id
    FROM pending_order_kiosk
    GROUP BY o_id
) AS groups");
$retrieving_data->execute();
$kiosk_total_orders = $retrieving_data->fetchColumn();
?>

<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Left Header -->
            <div class="header-left active">
                <a href="employee_index.php" class="logo">
                    <img src="../assets/img/logo.png" alt="">
                </a>
                <a href="employee.index.php" class="logo-small">
                    <img src="../assets/img/logo-small1.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);"></a>
            </div>

            <!-- User Menu -->
            <ul class="nav user-menu">
                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill"><?php echo $kiosk_total_orders; ?></span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="#" class="clear-noti" id="clearAll"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <?php foreach ($kiosk_data as $data) : ?>
                                    <li class="notification-message">
                                        <a href="sales/pending_list.php">
                                            <div class="media d-flex">
                                                <span class="avatar flex-shrink-0">
                                                    <img alt="" src="<?php echo FILEPATH; ?>/assets/img/profiles/alert.png">
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details"><span class="noti-title">Kiosk System send an order</span> <?php echo $data->o_id; ?> <span class="noti-title">is the order number</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                </li>
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="../assets/img/profiles/avator1.jpg" alt=""><span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <!-- Profile Info -->
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="../assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="../auth/logout.php"><img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Mobile User Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.php">Settings</a>
                    <a class="dropdown-item" href="<?php echo "" . FILEPATH . ""; ?>/auth/logout.php">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="employee_index.php"><img src="../assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="../assets/img/icons/product.svg" alt="img"><span>
                                    Product</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="product/product_list.php">Product List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="../assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="sales/sales_list.php">Sales List</a></li>
                                <li><a href="sales/pending_list.php">Pending Orders</a></li>
                                <li><a href="sales/pos.php">POS</a></li>

                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="people/add_customer.php">Add Customer </a></li>
                                <li><a href="people/customer_list.php">Customer List</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="../assets/img/icons/time.svg" alt="img"><span>
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
                <!-- Dashboard Widgets -->
                <div class="row">

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/dash1.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5> ₱<span class="counters" data-count="<?php echo $total_inventory; ?>"></span></h5>
                                <h6>Total Inventory quantity</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/dash2.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5> ₱<span class="counters" data-count="<?php echo $shop_income; ?>"> </span></h5>
                                <h6>Total Income</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/dash3.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5> ₱<span class="counters" data-count="<?php echo $total_exchange; ?>"></span></h5>
                                <h6>Total Exchange Amount</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="<?php echo FILEPATH; ?>/assets/img/icons/dash4.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₱<span class="counters" data-count="<?php echo $total_order; ?>"></span></h5>
                                <h6>Total Order Amount</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!--transaction records -->
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
                                            <td><?php echo $info->emp_id; ?></td>
                                            <td><?php echo $info->customer_id; ?></td>
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

    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#clearAll').on('click', function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag

            if (confirm("Are you sure you want to clear all?")) {
                $.ajax({
                    url: '../process/pos_crud/kiosk_process.php',
                    method: 'POST',
                    data: {
                        clear_all: true
                    },
                    success: function(response) {
                        // Handle success (optional)
                        alert('All data cleared!');
                        // Redirect if needed
                        window.location.href = 'employee_index.php';
                    },
                    error: function(xhr, status, error) {
                        // Handle error (optional)
                        console.error(xhr.responseText);
                        alert('Error clearing data!');
                    }
                });
            }
        });
    });
</script>

</html>