<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php
// For category display
$search = $connection->query("SELECT * FROM category");
$search->execute();
$category_list = $search->fetchAll(PDO::FETCH_OBJ);
// For product display
$product_search = $connection->query("SELECT * FROM inventory");
$product_search->execute();
$product_list = $product_search->fetchAll(PDO::FETCH_OBJ);
// For customer transaction display
$customer_search = $connection->query("SELECT * FROM customers WHERE id= 3004");
$customer_search->execute();
$customer_data = $customer_search->fetchAll(PDO::FETCH_ASSOC);

foreach($customer_data as $customer_info)
{
    $customer_code = $customer_info['recovery_code'];
}
// possible join session 
// Displaying order details
// Getting the stored or a new order ID
$order_id = isset($_GET['orderId']) ? $_GET['orderId'] : '';

if (empty($order_id)) {
    // If not found in URL, try retrieving from the session
    $order_id = isset($_SESSION['o_id']) ? $_SESSION['o_id'] : '';

    // If still empty, fetch the last o_id from the database and increment by 1
    if (empty($order_id)) {
        $getLastOrderId = $connection->query("SELECT MAX(o_id) AS last_order_id FROM pending_orders");
        $lastOrderId = $getLastOrderId->fetchColumn();

        // Generate a new order ID by incrementing the last order ID
        $order_id = $lastOrderId + 1;
    }
}

// Store the order ID in the session for future use
$_SESSION['o_id'] = $order_id;// eto ung session sa order id
$retrieving_data = $connection->query("SELECT inv.id AS product_id, inv.product_name, cat.category_name, pending.o_quantity AS ordered_quantity, inv.price, inv.image, inv.quantity, pending.o_id as order_id 
    FROM Inventory inv 
    INNER JOIN category cat ON inv.category_id = cat.id 
    INNER JOIN pending_orders pending ON inv.id = pending.product_id
    WHERE pending.o_id = $order_id"); // Add a condition to select orders with the specific order ID
$retrieving_data->execute();
$pending_order_data = $retrieving_data->fetchAll(PDO::FETCH_ASSOC);

// Counting values fro the pending table
$pending_count = $connection->prepare("SELECT COUNT(*) FROM pending_orders WHERE o_id = :order_id");
$pending_count->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$pending_count->execute();
$total_count_pending = $pending_count->fetchColumn();
?>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrappers">
        <div class="header">

            <div class="header-left border-0 ">
                <a href="../admin_index.php" class="logo">
                    <img src="<?php echo FILEPATH; ?>/assets/img/dlogo.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="<?php echo FILEPATH; ?>/assets/img/logo-small1.png" alt="">
                </a>
            </div>


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
                            <a class="dropdown-item" href="profile.html"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2">
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
                        <ul class="tabs owl-carousel owl-theme owl-product border-0">
                            <?php foreach ($category_list as $category) : ?>
                                <li id="<?php echo $category->id; ?>">
                                    <a class="product-details">
                                        <h6><?php echo $category->category_name; ?></h6>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tabs_container">
                            <?php foreach ($category_list as $category) : ?>
                                <div class="tab_content" data-tab="<?php echo $category->id; ?>">
                                    <div class="row">
                                        <?php 
                                        
                                        $category_name =$connection->query( "SELECT Category.category_name
                                        FROM Category
                                        JOIN inventory ON Category.id = inventory.category_id
                                        WHERE inventory.category_id = '$category->id'");
                                        $category_name -> execute();
                                        $product_category =  $category_name ->fetchColumn();

                                        foreach ($product_list as $product) : ?>
                                            <?php if ($product->category_id ===$category->id) : ?>
                                                <div class="col-lg-3 col-sm-6 d-flex">
                                                    <div class="productset flex-fill">
                                                        <div class="productsetimg image-container">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#ShowModal1">
                                                                <img onclick="php_to_html('<?php echo $product->id; ?>', '<?php echo $product->price; ?>','<?php echo $product_category; ?>', '<?php echo $product->product_name; ?>', '<?php echo $product->quantity; ?>','<?php echo 1; ?>')" src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" alt="img">
                                                            </a>
                                                            <h6><?php echo $product->quantity ?></h6>
                                                        </div>
                                                        <div class="productsetcontent">
                                                            <h5><?php echo $product_category ?></h5>
                                                            <h4><?php echo $product->product_name ?></h4>
                                                            <h6></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 ">
                        <div class="order-list">
                            <div class="orderid">
                                <h4>Order List</h4>
                                <h5>Order Id: <?php echo isset($_SESSION['o_id']) ? $_SESSION['o_id'] : 'N/A'; ?></h5>
                            </div>

                        </div>
                        <div class="card card-order">

                            <div class="card-body pt-0">
                                <div class="totalitem">
                                    <h4>Total items : <?php echo $total_count_pending?></h4>
                                    <a href="javascript:void(0);">Clear all</a>
                                </div>
                                <div class="product-table">
                                    <!--foreach loop-->                                  
                                    <?php foreach($pending_order_data as $order_data):?>
                                    <?php   $product_price=$order_data['price'];
                                            $product_category=$order_data['category_name'];
                                            $product_quantity=$order_data['ordered_quantity'];
                                            $product_id=$order_data['order_id'];
                                            $product_storage_quantity=$order_data['quantity'];
                                            $prices = $product_price * $product_quantity;
                                    ?>
                                    <ul class="product-lists">
                                        <li>
                                            <div class="productimg">
                                                <div class="productimgs">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product_image=$order_data['image'];?>" alt="img">
                                                </div>
                                                <div class="productcontet">
                                                    <h4><?php echo $product_name=$order_data['product_name'];?>                                                   
                                                        <a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="<?php echo FILEPATH; ?>/assets/img/icons/edit-5.svg" alt="img"></a>
                                                    </h4>
                                                    <div class="productlinkset">
                                                        <h5><?php echo $product_category;?></h5>
                                                    </div>
                                                    <div class="increment-decrement">
                                                        <div class="input-groups">
                                                            <p>Quantity: <?php echo $product_quantity;?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#ShowModal1"><p onclick="php_to_html('<?php echo $product_id; ?>', '<?php echo $product_price; ?>','<?php echo $product_category; ?>', '<?php echo $product_name; ?>', '<?php echo $product_storage_quantity; ?>','<?php echo $product_quantity; ?>')">Edit</p></a></li>
                                        <li>₱<?php echo $prices;?></li>
                                        <li>
                                            <a data-bs-toggle="modal" onclick="delete_account(<?php echo $product_id; ?>);" data-bs-target="#deleteProductModal" data-productid="<?php echo $product_id; ?>">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/delete.svg" alt="Delete">
                                            </a>
                                        </li>
                                    </ul>
                                    <?php endforeach;?>                                        
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
                                        <li>
                                            <h5>Exchange </h5> <input style="width: 50px; text-align:right;" type="text" name="child" value="" class="quantity-field">
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

    <!-- DELETE CONFIRMATION MODAL FROM BOOTSRAP-->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <form action="../process/pos_crud/pending_order_Delete.php" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to remove this product?
                            <input type="hidden" id="id_delete" name="id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete_product_order" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </form>
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
                    <!--FORM ACTION-->
                    <form action="../process/pos_crud/pending_order.php" method="POST">
                        <!--Product_name-->
                        <div class="form-group">
                            <input type="text" style=" display: block; margin: 0 auto; border: none; color: black;
                                         background-color: transparent; font-weight: bold; text-align: center; font-size: 18px" name="product_name" id="product_name" readonly>
                        </div>

                        <label>Quantity</label>
                        <div class="row">
                            <div class="increment-decrement col-4">
                                <div class="input-groups">
                                    <input type="button" onclick="Minus_button()" value="-" class="button-minus  button">
                                    <!--Order Current Quantity-->
                                    <input type="text" id="current_quantity" name="current_quantity" value="" class="quantity-field " readonly>
                                    <input type="button" onclick="Add_button()" value="+" class="button-plus button ">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <!--Product_id, Customer code-->
                                    <input type="text" id="edit_price" name="price" readonly>
                                    <input type="hidden" id="product_id" name="product_id">
                                    <input type="hidden" id="$customer_code" name="customer_code" value="<?php  echo ''.$customer_code.'';?>">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Total Price</label>
                                    <!--Total_points -->
                                    <input type="text" id="total_price" name="total_price" readonly>
                                    <input type="hidden" id="total_points" name="total_points">
                                </div>
                            </div>
                        </div>
                </div>
                <div style="justify-content: end !important;" class="modal-footer">
                    <label>Availability:</label> <!--Storage quantity-->
                    <input style="margin-right: 383px; text-align: center; width: 30px;" type="text" id="avalability" name="avalability">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-submit" name="submit-button-edit">Submit</button>
                </div>
                </form>
                <!--end of FORM ACTION-->
            </div>
        </div>
    </div>
    
    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>
<script>
    function php_to_html(id, price,category_name, product_name, quantity,initial) {

        // Access the input element by its ID
        var inputElement = document.getElementById("current_quantity");

        $('#product_id').val(id);
        // Set the default value to "1"
        inputElement.value = initial;
        var quantity = quantity - initial;
        $('#edit_price').val(price);
        $('#avalability').val(quantity);
        $('#product_name').val(product_name);
        $('#total_price').val(total_price = price * initial);
    }
    //For adding quantity of the edit order transaction
    function Add_button() {
        //Getting data from the html table
        var counter = parseInt($('#current_quantity').val());
        var overall_quantity = $('#avalability').val();
        var current_price = $('#edit_price').val();


        //if the Overall Quantity of product from the storage doesn't reach zero the below code will happen
        if (overall_quantity > 0) {

            //Declaring variable for overall quantity on customer transaction
            var adding_quantity = counter + 1;
            $('#current_quantity').val(adding_quantity);


            //Declaring variables for the total price of customer transaction
            var totalPrice = parseInt($('#current_quantity').val()) * current_price;

            //Subtituting the result from the current display
            $('#total_price').val(totalPrice);

            //Declaring variable for overall quantity on inventory
            var total_quantity = overall_quantity - 1;
            $('#avalability').val(total_quantity);
        }
    }
    //For subtracting quantity of order transaction
    function Minus_button() {
        //Getting data from the html table
        var counter = parseInt($('#current_quantity').val());
        var overall_quantity = parseInt($('#avalability').val());
        var current_price = $('#edit_price').val();

        //if the Quantity of product doesn't reach zero the below code will happen
        if (counter > 0) {
            //Declaring variable for overall quantity on inventory
            var total_quantity = overall_quantity + 1;
            $('#avalability').val(total_quantity);
            //Declaring variable for overall quantity on customer transaction
            var adding_quantity = counter - 1;
            $('#current_quantity').val(adding_quantity);


            //Declaring variables for the total price of customer transaction
            var totalPrice = parseInt($('#current_quantity').val()) * current_price;

            //Subtituting the result from the current display
            $('#total_price').val(totalPrice);

        }
    }
    function delete_account(id) 
            {
                $('#id_delete').val(id);
            }
</script>

</html>