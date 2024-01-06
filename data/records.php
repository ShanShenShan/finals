<?php require "../includes/header.php"; ?> <!-- Strictly requiring to include the header.php-->
<?php require "../config/connection.php"; ?> <!-- Strictly requiring to include the connection.php-->
<?php require "../includes/redirecting.php"; ?> <!-- Strictly requiring to include the redirecting.php-->
<?php require "../includes/sidebar.php"; ?> <!-- Strictly requiring to include the sidebar.php-->

<?php

//getting data on transaction table
$transaction_search = $connection->query("SELECT * FROM transaction_records");
$transaction_search->execute();
$transaction_data =  $transaction_search->fetchAll(PDO::FETCH_OBJ);

?>

<body>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Transaction History List</h4>
                    <h6>Manage your Transaction History List</h6>
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
                                        <th>Id</th>
                                        <th>Transaction date</th>
                                        <th>Employee Id </th>
                                        <th>Cutomer Id</th>
                                        <th>Total amount</th>
                                        <th>Cash amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaction_data as $info) : ?><!--Iterating each value from admin list and assigning it to $admin-->
                                        <tr>

                                            <td><?php echo $info->id; ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);"><?php echo $info->tr_date; ?></a>
                                            </td>
                                            <td><?php echo $info->emp_id ; ?></td>
                                            <td><?php echo $info->customer_id ; ?></td>
                                            <td><?php echo $info->total_amount; ?></td>
                                            <td><?php echo $info->cash_amount; ?></td>
                                            <td>
                                                <a class="me-3" href="<?php echo FILEPATH;?>/sales/sales_list.php?id=<?php echo  $info->id; ?>">
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