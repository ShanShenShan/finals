<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php
    
    $search = $connection->query("SELECT o_id, u.name as customer_name, po.product_id, po.o_quantity, i.product_name, i.category_id, i.quantity, i.product_points, i.price
    FROM pending_orders po
    JOIN users u ON po.customer_id = u.unique_id
    JOIN inventory i ON po.product_id = i.id
    GROUP BY po.o_id");
    $search->execute();

    $orderList = $search->fetchAll(PDO::FETCH_OBJ);

?>

<body>

    <div class="main-wrapper">


        <div class="page-wrapper">
    <div class="content">
        <div class="page-header">
        <div class="page-title">
                        <h4>Order List</h4>
                        <h6>Manage your Orders</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Order Details</th>
                                    </tr>
                                </thead>
                                <?php foreach($orderList as $order) : ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $order->o_id ;?></td>
                                            <td><?php echo $order->customer_name;?></td>
                                            <td>
                                            <a class="me-3" onclick="openReviewModal('<?php echo $order->o_id; ?>')">
                                                <img src="<?php echo FILEPATH;?>/assets/img/icons/excel.svg" alt="img">
                                            </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal Content -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- modal-lg for a larger modal, adjust as needed -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Total Points</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailsTableBody">
                        <!-- Populate this tbody dynamically using AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="validateOrder()">Validate</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openReviewModal(orderId) {
        // Implement AJAX call to fetch order details based on orderId
        $.ajax({
            url: '../process/pos_crud/get_order_details.php',
            method: 'POST',
            data: {orderId: orderId},
            success: function(response) {
                // Update the modal content with the retrieved order details
                $('#orderDetailsTableBody').html(response);

                // Show the modal
                $('#reviewModal').modal('show');
            },
            error: function(error) {
                console.error('Error fetching order details:', error);
            }
        });
    }

    function validateOrder() {
        // Implement logic to handle order validation
        // This function is called when the "Validate" button is clicked
        // Redirect to "pos.php" or perform other validation actions
        window.location.href = 'pos.php';
    }
</script>



<?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>