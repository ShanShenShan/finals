<?php require "../../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $connection->prepare("SELECT
    inv.product_name,
    cat.category_name,
    inv.price,
    inv.image,
    tp.id AS transaction_product_id,
    tp.tr_id AS tr_id,
    tp.product_id,
    tp.quantity,
    tp.o_quantity,
    tr.total_amount,
    tr.cash_amount,
    tr.emp_id AS employee_id,
    usr.name AS employee_name
FROM
    inventory inv
INNER JOIN
    category cat ON inv.category_id = cat.id
INNER JOIN
    transaction_products tp ON inv.id = tp.product_id
INNER JOIN
    transaction_records tr ON tp.tr_id = tr.customer_id
INNER JOIN
    users usr ON tr.emp_id = usr.id
WHERE
    tr.customer_id = :id");

    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $transaction_details = $query->fetchAll(PDO::FETCH_OBJ);

    foreach ($transaction_details as $transaction_info) {
        $customer_id = $transaction_info->tr_id;
        $transaction_product_id = $transaction_info->transaction_product_id;
        $product_id = $transaction_info->product_id;
        $product_name = $transaction_info->product_name;
        $category_name = $transaction_info->category_name;
        $product_price = $transaction_info->price;
        $storage = $transaction_info->quantity;
        $order_quantity = $transaction_info->o_quantity;
        $product_image = $transaction_info->image;
        $total_amount = $transaction_info->total_amount;
        $cash_amount = $transaction_info->cash_amount;

        // Use the fetched data here as needed
    }
}


?>

<body>
    <div class="page-wrapper">
        <div class="content">



            <div class="page-header">
                <div class="page-title">
                    <h4>Transaction Details</h4>
                    <h6>Full details of the customers transaction</h6>
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

                            </div>
                        </div>
                    </div>
                    <!--Table data of the products-->
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>Transaction id</th>
                                    <th>Employee id</th>
                                    <th>Employee name</th>
                                    <th>Customer</th>
                                    <th>Product id </th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Order Quantity</th>
                                    <th>Storage Quantity</th>
                                    <th>Total</th>
                                    <th>Cash Tendered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaction_details as $transaction_info) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                    <tr>
                                        <td><?php echo $transaction_product_id; ?></td>
                                        <td><?php echo $transaction_info->employee_id; ?></td>
                                        <td><?php echo $transaction_info->employee_name; ?></td>
                                        <td><?php echo $transaction_info->tr_id; ?></td>
                                        <td><?php echo $transaction_info->product_id; ?></td>
                                        <td><?php echo $transaction_info->product_name; ?></td>
                                        <td><?php echo $transaction_info->category_name; ?></td>
                                        <td><?php echo $transaction_info->price; ?></td>
                                        <td><?php echo $transaction_info->o_quantity; ?></td>
                                        <td><?php echo $transaction_info->quantity; ?></td>
                                        <td><?php echo $transaction_info->total_amount; ?></td>
                                        <td><?php echo $transaction_info->cash_amount; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php foreach ($transaction_details as $transaction_info) : ?>


                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bar-code-view">
                                    <p>Bar code Not available</p>
                                    <a class="printimg">
                                        <img src="<?php echo FILEPATH; ?>/assets/img/icons/printer.svg" alt="print">
                                    </a>
                                </div>
                                <div class="productdetails">
                                    <ul class="product-bar">
                                        <li>
                                            <h4>Product</h4>
                                            <h6><?php echo $transaction_info->product_name; ?> </h6>
                                        </li>
                                        <li>
                                            <h4>Category</h4>
                                            <h6><?php echo $transaction_info->category_name;
                                                ?></h6>
                                        </li>


                                        <li>
                                            <h4>Order Quantity</h4>
                                            <h6><?php echo $transaction_info->o_quantity;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Storage Quantity</h4>
                                            <h6><?php echo $transaction_info->quantity;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Price</h4>
                                            <h6><?php echo $transaction_info->price;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Total amount</h4>
                                            <h6><?php echo $transaction_info->total_amount;
                                                ?></h6>
                                        </li>

                                        <li>
                                            <h4>Cash tendered

                                            </h4>
                                            <h6><?php echo $transaction_info->cash_amount;
                                                ?></h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="slider-product-details">
                                    <div class="owl-carousel owl-theme product-slide">
                                        <div class="slider-product" style="text-align: center;"> <!-- Centering the content -->
                                            <img data-bs-target="#editProductModal" src="<?php echo FILEPATH; ?>/assets/img/product/<?php echo $transaction_info->image; ?>" alt="img" style="width: 200px; height: 300px; display: inline-block;"> <!-- Centering the image -->
                                            <h4><?php echo $transaction_info->product_name; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    <?php require "../../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>