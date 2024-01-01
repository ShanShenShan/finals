
<?php require "headings.php"; ?>
<!--Removing headings-->

<?php
$select_all = $connection->query("SELECT inventory.*, category.category_name
 FROM inventory
JOIN category ON inventory.category_id = category.id
 where category.category_name = 'Hot Drinks'
");
$select_all->execute();
$all_products = $select_all->fetchAll(PDO::FETCH_OBJ);
?>

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
                <div class="item">
                    <img src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" alt="" data-productname="<?php echo htmlspecialchars($product->product_name); ?>" data-category="<?php echo htmlspecialchars($product->category_name); ?>" data-price="<?php echo htmlspecialchars($product->price); ?>" data-description="<?php echo htmlspecialchars($product->description); ?>" data-image="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $product->image; ?>" data-id="<?php echo htmlspecialchars($product->id); ?>"> <!-- Include product ID -->
                    <h5><?php echo htmlspecialchars($product->product_name); ?></h5>
                    <div class="price">₱<?php echo htmlspecialchars($product->price); ?></div>
                    <input type="hidden" value="<?php echo htmlspecialchars($product->id); ?>"><!-- Include product ID -->
                    <button class="addCart">Add To Cart</button>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
    <!--Checkout Session-->
    <div class="cartTab">

        <h6>Customer id: 1234</h6> 

        <h1>Order Status</h1>

        <div class="listCart">

            <div class="item">

                <img src="../image/coffee.webp" alt="">

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
    <script src="../js/app.js"></script>
</body>

</html>