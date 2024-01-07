<?php
require "../includes/header.php";
require "../config/connection.php";
require "../includes/redirecting.php";
require "../includes/sidebar.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $search = $connection->query("SELECT tp.id, tp.tran_id, tp.product_id, tp.quantity, tp.o_quantity, i.product_name
                                  FROM transaction_products tp
                                  JOIN inventory i ON tp.product_id = i.id
                                  WHERE tran_id = $id");
    $search->execute();
    $sales_list = $search->fetchAll(PDO::FETCH_OBJ);
} else {
    $search = $connection->query("SELECT tp.id, tp.tran_id, tp.product_id, tp.quantity, tp.o_quantity, i.product_name
                                  FROM transaction_products tp
                                  JOIN inventory i ON tp.product_id = i.id");
    $search->execute();
    $sales_list = $search->fetchAll(PDO::FETCH_OBJ);
}
?>

<body>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Transaction Product List</h4>
                    <h6>Manage your Transaction Product List</h6>
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
                                    <th>id</th>
                                    <th>Transaction id</th>
                                    <th>Product Name</th>
                                    <th>Storage Quantity</th>
                                    <th>Order Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales_list as $sales_data) : ?>
                                    <tr>
                                        <td><?php echo $sales_data->id; ?></td>
                                        <td><?php echo $sales_data->tran_id; ?></td>
                                        <td><?php echo $sales_data->product_name; ?></td>
                                        <td><?php echo $sales_data->quantity; ?></td>
                                        <td><?php echo $sales_data->o_quantity; ?></td>
                                        <td>
                                            <a class="me-3" href="sales_detail.php?id=<?php echo $sales_data->tran_id; ?>">
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

    <?php require "../includes/footer.php"; ?> <!-- Strictly requiring to include the footer.php-->
</body>

</html>