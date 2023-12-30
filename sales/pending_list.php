<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php

//$search = $connection->query("SELECT o_id, u.name as customer_name, po.product_id, po.o_quantity, i.product_name, i.category_id, i.quantity, i.product_points, i.price
//FROM pending_orders po
//JOIN users u ON po.customer_id = u.unique_id
// JOIN inventory i ON po.product_id = i.id
//GROUP BY po.o_id");
//$search->execute();

//$orderList = $search->fetchAll(PDO::FETCH_OBJ);

//Selecting all data on the kiosk pending table
$retrieving_data = $connection->query("SELECT * FROM pending_order_kiosk");
$retrieving_data->execute();
$kiosk_data = $retrieving_data->fetchAll(PDO::FETCH_OBJ);
foreach ($kiosk_data as $data) {
    $order_id = $data->o_id;
    $customer_id = $data->customer_id;
    $product_id = $data->product_id;
}

// Selecting all the values that should be seen on the modal
$query = $connection->prepare("SELECT i.product_name, c.category_name, po.o_quantity, i.product_points, i.price,i.quantity as storage
        FROM pending_order_kiosk po
        JOIN inventory i ON po.product_id = i.id
        JOIN category c ON i.category_id = c.id
        WHERE po.o_id = :orderId");
$query->bindParam(':orderId', $order_id, PDO::PARAM_INT);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($data as $information) {
    $product_name = $information->product_name;
    $category_name = $information->category_name;
    $order_quantity = $information->o_quantity;
    $totalPrice = $information->price * $information->o_quantity;
    $storage = $information->storage;
}
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
                                        <th>Order Details</th>
                                    </tr>
                                </thead>
                                <?php foreach ($kiosk_data as $order) : ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $order->o_id; ?></td>
                                            <td>
                                                <a class="me-3" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                                    <img src="<?php echo FILEPATH; ?>/assets/img/icons/excel.svg" alt="img">
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
    </div>

    <!-- Review Modal Content -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg for a larger modal, adjust as needed -->
            <div class="modal-content">
                <form action="<?php echo FILEPATH; ?>/process/pos_crud/pending_order.php" method="POST">
                <?php $_SESSION['o_id'] = $customer_id;?>
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
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetailsTableBody">
                                <td value="<?php echo $product_name; ?>"><?php echo $product_name; ?></td>
                                <td value="<?php echo $category_name; ?>"><?php echo $category_name; ?></td>
                                <td name="current_quantity" value="<?php echo $order_quantity; ?>"><?php echo $order_quantity; ?></td>
                                <td value="<?php echo $totalPrice; ?>">₱<?php echo $totalPrice; ?></td>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Validate" name="pending_list">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>