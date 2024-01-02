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