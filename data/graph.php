<?php require "../includes/header.php"; ?>
<?php require "../config/connection.php"; ?>
<?php require "../includes/redirecting.php"; ?>
<?php require "../includes/sidebar.php"; ?>

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
                        <h4>Graphs</h4>
                        <h6>Visual Sales Data</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div style="width: 50%; position: relative;">
                            <canvas id="donutChartContainer" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "../includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Fetch data for the donut chart
            <?php
            $salesData = $connection->query("SELECT i.product_name, SUM(po.o_quantity) as total_quantity
                                             FROM pending_orders po
                                             JOIN inventory i ON po.product_id = i.id
                                             GROUP BY po.product_id");
            $salesData->execute();
            $salesData = $salesData->fetchAll(PDO::FETCH_ASSOC);
            ?>

            var donutChartData = {
                labels: <?php echo json_encode(array_column($salesData, 'product_name')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($salesData, 'total_quantity')); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66ff66', '#ff9966'],
                }],
            };

            // Create the donut chart
            var donutChartContext = document.getElementById("donutChartContainer").getContext("2d");
            var donutChart = new Chart(donutChartContext, {
                type: 'doughnut',
                data: donutChartData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Sales Count Graph',
                    },
                },
            });
        });
    </script>
</body>

</html>
