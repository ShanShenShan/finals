<?php require "../../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->

<?php
// If submit button has been clicked the below code will happen
if (isset($_POST['submit'])) {

    // Getting the user's input from the form html
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Searching the celected input and executing it
    $search = $connection->query("SELECT inventory.*, category.category_name
    FROM inventory
    JOIN category ON inventory.category_id = category.id
    WHERE product_name = '$name' OR category_name = '$category' OR price = $price;");
    $search->execute();
    $productlist = $search->fetchAll(PDO::FETCH_OBJ); // Fetch the results into an array

    $search_category = $connection->query("SELECT * FROM category ");

$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);
}
else{
    // Query to select all data on the table that have admin role
$search = $connection->query("SELECT inventory.*, category.category_name 
FROM inventory 
JOIN category ON inventory.category_id = category.id");


$search->execute();
$productlist = $search->fetchAll(PDO::FETCH_OBJ); // fetching all of the data as an object

$search_category = $connection->query("SELECT * FROM category ");

$search_category->execute();
$product_category = $search_category->fetchAll(PDO::FETCH_OBJ);

$search_price = $connection->query("SELECT * FROM inventory GROUP BY price ");

$search_price->execute();
$product_price = $search_price->fetchAll(PDO::FETCH_OBJ);
}
?>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="../employee_index.php" class="logo">
                    <img src="<?php echo"".FILEPATH."";?>/assets/img/logo.png" alt="">
                </a>
                <a href="../employee_index.php" class="logo-small">
                    <img src="<?php echo"".FILEPATH."";?>/assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!--PROFILE SECTION-->
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="<?php echo"".FILEPATH."";?>/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?php echo"".FILEPATH."";?>/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h5><?php $username = $_SESSION['username'];
                                        echo "$username"; ?></h5> <!-- Calling the Session variable from the other page-->
                                    <h6><?php $username = $_SESSION['role'];
                                        echo "$username"; ?></h6>
                                </div>
                            </div>
                            <a class="dropdown-item logout pb-0" href="<?php echo"".FILEPATH."";?>/auth/logout.php"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.php">Settings</a>
                    <a class="dropdown-item" href="<?php echo"".FILEPATH."";?>/auth/logout.php">Logout</a>
                </div>
            </div>

        </div>
        <!--SIDEBAR SECTION-->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="../employee_index.php"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/product.svg" alt="img"><span>
                                    Product</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="product_list.php">Product List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="saleslist.php">Sales List</a></li>
                                <li><a href="pos.php">POS</a></li>

                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="<?php echo"".FILEPATH."";?>/assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
                            <ul>
                            <li><a href="../people/add_customer.php">Add Customer </a></li>
                                <li><a href="../people/customer_list.php">Customer List</a></li>                           
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

        <div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>Manage your Product</h6>
            </div>
        </div>

        <div class="card">
                    <div class="card-body">
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
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
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
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
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


<?php require "../../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>