<?php 
require "../config/connection.php";
session_start();

define("FILEPATH", "http://localhost/pos1");

// Fetch all products from the inventory along with their categories
$select_all = $connection->query("SELECT inventory.*, category.category_name
FROM inventory
JOIN category ON inventory.category_id = category.id
");
$all_products = $select_all->fetchAll(PDO::FETCH_OBJ);

// Check if the session variables are set
if (!isset($_SESSION['kiosk_email'])) {
    // If no email is set but an ID is present, retrieve a default account ID from the database
    $default_account = $connection->query("SELECT * FROM customers WHERE id = 3007");
    $customer_data = $default_account->fetchAll(PDO::FETCH_OBJ);
    foreach($customer_data as $data)
    {
        $customer_id = $data->id;
        $order_id = $data->unique_code;
    }
    // Store the customer ID and order_id in the session for future use
    //$_SESSION['o_id'] = $customer_id;
} else {
    // If session variables are set, retrieve the ID and assign it to a session variable
    $customer_id = $_SESSION['id'];
    //$_SESSION['o_id'] = $customer_id;
    $verified_account = $connection->query("SELECT unique_code FROM customers WHERE id = $customer_id");
    $order_id = $verified_account->fetchColumn();
}
?>


<!-- IMPORTANT NOTES!!! IMPORTANT NOTES!!!IMPORTANT     DESTTROY THE SESSION, add to cart      NOTES!!!IMPORTANT NOTES!!!IMPORTANT NOTES!!! -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keffie-Cafe</title>
    <link rel="stylesheet" href="Style/style.css">
    <link rel="shortcut icon" href="../image/logo.jpg" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="">
    <nav class="sidebar appear">
        <header>
            <div class="image-text">

                <a href="index.php">
                    <span class="image">
                        <img src="image/logo.jpg" alt="">
                    </span>
                </a>
                <div class="text header-text">
                    <span class="name">Keffie-Cafe <?php echo $customer_id;?></span> <!--pansamantalang order id-->
                </div>
            </div>
        </header>

        <!--Sidebar Section-->
        <div class="menu-bar">

            <div class="menu">

                <ul class="menu-links">

                    <li class="nav-link">
                        <a href="sidebars/coffee.php">
                            <i class='bx bxs-coffee-bean icon'></i>
                            <span class="text nav-text">Coffee</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/hotdrinks.php">
                            <i class='bx bx-coffee-togo icon'></i>
                            <span class="text nav-text">Hot Drinks</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/frappes.php">
                            <i class='bx bxs-coffee-alt icon'></i>
                            <span class="text nav-text">Frappes</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/icedrinks.php">
                            <i class='bx bxs-coffee icon'></i>
                            <span class="text nav-text">Iced Drinks</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/milk.php">
                            <i class='bx bxs-leaf icon'></i>
                            <span class="text nav-text">Milk Teas</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/fruit.php">
                            <i class='bx bxs-lemon icon'></i>
                            <span class="text nav-text">Fruit Teas</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/softdrinks.php">
                            <i class='bx bxs-drink icon'></i>
                            <span class="text nav-text">Softdrinks</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/rice.php">
                            <i class='bx bxs-bowl-rice icon'></i>
                            <span class="text nav-text">Rice Meals</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/breakfast.php">
                            <i class='bx bxs-baguette icon'></i>
                            <span class="text nav-text">All Day Breakfast</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/pasta.php">
                            <i class='bx bxs-bowl-hot icon'></i>
                            <span class="text nav-text">Pasta & Noodles</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/kiddiepasta.php">
                            <i class='bx bxs-bowl-hot icon'></i>
                            <span class="text nav-text">Kiddie Pasta</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/soup.php">
                            <i class='bx bxs-bowl-rice icon'></i>
                            <span class="text nav-text">Soup & Vegetables</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/alltime.php">
                            <i class='bx bxs-bowl-rice icon'></i>
                            <span class="text nav-text">All Time Favorites</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/addons.php">
                            <i class='bx bx-cart-add icon'></i>
                            <span class="text nav-text">Add - Ons</span>
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>
    <!--Cart icon and Item section-->
    <div class="container">
        <!--Cart section-->
        <header>

            <div class="title">PRODUCT LIST</div>

            <div class="icon-cart">

                <i class='bx bx-cart'></i>
                <span>0</span>

            </div>

        </header>

        <div class="listProduct">
            <?php foreach ($all_products as $product) : ?>
                <?php
                    // 
                    $storage_quantity=$connection->query("SELECT quantity FROM inventory where id =$product->id ");
                    $storage_quantity->execute();
                    $quantity=$storage_quantity->fetchColumn(); 00000000000000000000000
                    ?>
                <form action="<?php echo FILEPATH;?>/process/pos_crud/kiosk_process.php" method="POST">
                    <div class="item">
                        <img src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" alt="" data-productname="<?php echo htmlspecialchars($product->product_name); ?>" data-category="<?php echo htmlspecialchars($product->category_name); ?>" data-price="<?php echo htmlspecialchars($product->price); ?>" data-description="<?php echo htmlspecialchars($product->description); ?>" data-image="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" data-id="<?php echo htmlspecialchars($product->id); ?>"> <!-- Include product ID -->
                        <h5><?php echo htmlspecialchars($product->product_name); ?></h5>
                        <div class="price">₱<?php echo $product->price; ?></div>
                        <input type="hidden" value="<?php echo $product->id ?>"><!-- Include product ID -->
                        <input type="hidden" value="<?php echo $customer_id; ?>">
                        <input type="hidden" value="<?php echo $order_id; ?>">
                        <input type="text" value="<?php echo $quantity; ?>">
                        <button type="submit" name="add-to-cart" class="addCart"> Add To Cart</button>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>


    </div>
    <!--Checkout Session-->
    <div class="cartTab">

        <h1>Order Status</h1>

        <div class="listCart">

            <div class="item">

                <img src="image/coffee.webp" alt="">

                <div class="name">

                    <div class="name">NAME</div>
                    <div class="variant">VARIANT</div>

                </div>

                <div class="totalPrice">
                    ₱ 59
                </div>

                <div class="quantity">
                    <span class="minus">&lt;</span>
                    <span>1</span>
                    <span class="plus">&gt;</span>
                </div>

                <i class='bx bx-trash icon'></i>

            </div>

        </div>

        <div class="btn">
            <button class="close">CLOSE</button>
            <button class="checkOut" id="checkOut">CHECK OUT</button>
        </div>


    </div>
    <!--Modal pre-done Section-->
    <div class="modal" id="ShowModal" tabindex="-1" aria-labelledby="ShowModal1" aria-hidden="true" style="display: none;">

        <div class="h1-text">
            <h4>Are you sure to proceed <br> to check out your orders?</h4>
        </div>

        <button class="btn" id="no">No</button>
        <button class="btn" id="yes">Yes</button>

    </div>
    <!--Modal done Section-->
    <div class="modal2" id="ShowModal2" tabindex="-1" aria-labelledby="ShowModal2" aria-hidden="true" style="display: none;">

        <div class="h1-text">
            <h4>Your order is being processed</h4>
            <p>Please submit this order ID to the counter section. Thank you!</p>
        </div>

        <button class="btn" id="understand">I understand</button>

    </div>

    <!--Show product Description modal-->
    <div class="modal3" id="ShowModal3" tabindex="-1" aria-labelledby="ShowModal3" aria-hidden="true" style="display: none;">
        <div class="item">
            <picture>
                <!-- Fallback for browsers that don't support <picture> -->
                <img src="image/coffee.jpg" alt="Coffee">
            </picture>

            <h4>NAME PRODUCT</h4>
            <h5>Category</h5>
            <div class="price">₱59</div>
            <div class="description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo eaque odit iste minima consectetur, sit, saepe iure quia porro cum optio ducimus exercita
            </div>
            <input type="hidden" class="product-id"> <!-- Hidden input for product ID -->
            <div class="buttons">
                <button class="btn" id="close">
                    Close
                </button>
            </div>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>

</html>