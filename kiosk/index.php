<?php require "../config/connection.php"; ?>
<?php
session_start();
define("FILEPATH", "http://localhost/pos1");

$select_all = $connection->query("SELECT inventory.*, category.category_name
FROM inventory
JOIN category ON inventory.category_id = category.id
");
$select_all->execute();
$all_products = $select_all->fetchAll(PDO::FETCH_OBJ);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keffie-Cafe</title>
    <link rel="stylesheet" href="Style/style.css">
    <link rel="shortcut icon" href="../image/logo.jpg" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/4a85ec1aea.js" crossorigin="anonymous"></script>

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
                    <span class="name">Keffie-Cafe</span>
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
                            <i class='bx bxs-leaf icon logout'></i>
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
                            <i class="fa-solid fa-bottle-water icon"></i>
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
                            <i class="fa-solid fa-egg icon"></i>
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
                            <i class='bx bxs-star icon'></i>
                            <span class="text nav-text">All Time Favorites</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="sidebars/addons.php">
                            <i class='bx bx-cart-add icon'></i>
                            <span class="text nav-text">Add - Ons</span>
                        </a>
                    </li>

                    <li class="nav-link">
                       <a href="login.php">
                           <i class='bx bx-log-out icon' ></i>
                           <span class="text nav-text">Log Out</span>
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
                    $quantity=$storage_quantity->fetchColumn();
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

       
        <h6>Customer id: 1234</h6>   

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
                <button class="btn" id="addToCart">
                    Add To Cart
                </button>
            </div>
        </div>
    </div>




    <script src="js/app.js"></script>
    <script>
    $(document).ready(function () {
        // Initialize cart array
        var cart = [];

        // Add to Cart button click event
        $(".addCart").on("click", function () {
            // Get product information from the clicked item
            var product = {
                id: $(this).siblings("input[type=hidden]").val(),
                name: $(this).siblings("h5").text(),
                price: $(this).siblings(".price").text(),
                image: $(this).siblings("img").attr("src"),
                quantity: 1 // You can set an initial quantity here
            };

            // Check if the product is already in the cart
            var existingProductIndex = cart.findIndex(function (item) {
                return item.id === product.id;
            });

            if (existingProductIndex !== -1) {
                // If the product is already in the cart, update its quantity
                cart[existingProductIndex].quantity++;
            } else {
                // If the product is not in the cart, add it
                cart.push(product);
            }

            // Update the cart tab
            updateCartTab();
        });

        // Function to update the cart tab
        function updateCartTab() {
            // Clear existing cart items
            $(".listCart").empty();

            // Display each item in the cart
            cart.forEach(function (item, index) {
                var cartItemHtml = '<div class="item">' +
                    '<img src="' + item.image + '" alt="">' +
                    '<div class="name">' +
                    '<div class="name">' + item.name + '</div>' +
                    '<div class="variant">VARIANT</div>' +
                    '</div>' +
                    '<div class="totalPrice">' + item.price + '</div>' +
                    '<div class="quantity">' +
                    '<span class="minus" data-index="' + index + '">&lt;</span>' +
                    '<span>' + item.quantity + '</span>' +
                    '<span class="plus" data-index="' + index + '">&gt;</span>' +
                    '</div>' +
                    '<i class="bx bx-trash icon delete-btn" data-index="' + index + '"></i>' +
                    '</div>';

                $(".listCart").append(cartItemHtml);
            });

            // Update the cart icon with the total number of items in the cart
            $(".icon-cart span").text(cart.length);

            // Attach click event to delete buttons
            $(".delete-btn").on("click", function () {
                // Get the index of the item to be removed
                var indexToRemove = $(this).data("index");

                // Remove the item from the cart array
                cart.splice(indexToRemove, 1);

                // Update the cart tab
                updateCartTab();
            });

            // Attach click event to minus buttons
            $(".quantity .minus").on("click", function () {
                // Get the index of the item to be updated
                var indexToUpdate = $(this).data("index");

                // Decrease the quantity of the item in the cart array
                if (cart[indexToUpdate].quantity > 1) {
                    cart[indexToUpdate].quantity--;
                }

                // Update the cart tab
                updateCartTab();
            });

            // Attach click event to plus buttons
            $(".quantity .plus").on("click", function () {
                // Get the index of the item to be updated
                var indexToUpdate = $(this).data("index");

                // Increase the quantity of the item in the cart array
                cart[indexToUpdate].quantity++;

                // Update the cart tab
                updateCartTab();
            });
        }

            // Open/Close Cart tab
            $(".icon-cart, .close").on("click", function () {
                $(".cartTab").toggleClass("open");
            });

            // Checkout button click event
            $("#checkOut").on("click", function () {
                // Show the confirmation modal
                $("#ShowModal").css("display", "block");
            });

            // Modal "Yes" button click event
$("#yes").on("click", function () {
    // Hide the confirmation modal
    $("#ShowModal").css("display", "none");

    // Process the order and insert into the database
    if (cart.length > 0) {
        // Find the latest o_id
        // NEEDS FIXING ASAP!!!!!!
        // KELANGAN o_id ung dinedetect nya hindi product_id
        var latestOrderId = 0;
        if (cart.length > 0) {
            latestOrderId = Math.max(...cart.map(item => item.id));
        }

        // Increment o_id for the new order
        var newOrderId = latestOrderId + 1;

        // Prepare the SQL statement
        var insertStatement = "INSERT INTO pending_order_kiosk (o_id, product_id, customer_id, o_quantity, storage_quantity) VALUES ";
        var valueStrings = [];

        // Build the values part of the SQL statement
        cart.forEach(function (item) {
            var valueString = `(${newOrderId}, ${item.id}, 3005, ${item.quantity}, ${item.quantity})`;
            valueStrings.push(valueString);
        });

        // Join all value strings
        insertStatement += valueStrings.join(", ");

        // Execute the SQL statement using AJAX or any other suitable method
        $.ajax({
            type: "POST",
            url: "../process/kiosk_crud/insert_order.php", //file handling database insertion
            data: { sql: insertStatement }, // Send the SQL statement to the server
            success: function (response) {
                console.log("Order inserted successfully!");
            },
            error: function (error) {
                console.error("Error inserting order:", error);
            }
        });
    }

    // Show the processing modal
    $("#ShowModal2").css("display", "block");

    // Clear the cart after processing the order
    cart = [];
    updateCartTab();
});

            // Modal "No" button click event
            $("#no").on("click", function () {
                // Hide the confirmation modal
                $("#ShowModal").css("display", "none");
            });

            // Modal2 "I understand" button click event
            $("#understand").on("click", function () {
                // Hide the processing modal
                $("#ShowModal2").css("display", "none");
            });

            // Product item click event to show the description modal
            $(".item img").on("click", function () {
                // Get product information from the clicked item
                var productId = $(this).siblings("input[type=hidden]").val();
                var product = cart.find(function (item) {
                    return item.id === productId;
                });

                // Update the description modal content
                $(".modal3 .item img").attr("src", product.image);
                $(".modal3 .item h4").text(product.name);
                // ... (update other fields as needed)

                // Show the description modal
                $("#ShowModal3").css("display", "block");
            });

            // Description modal "Close" button click event
            $("#close").on("click", function () {
                // Hide the description modal
                $("#ShowModal3").css("display", "none");
            });
        });
    </script>

</body>

</html>