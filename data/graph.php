<?php require "../includes/header.php"; ?>
<?php require "../config/connection.php"; ?>
<?php require "../includes/redirecting.php"; ?>
<?php require "../includes/sidebar.php"; ?>

<?php
$search = $connection->query("SELECT i.product_name, SUM(po.o_quantity) as total_quantity
                             FROM pending_orders po
                             JOIN inventory i ON po.product_id = i.id
                             GROUP BY po.product_id");
$search->execute();

$salesData = $search->fetchAll(PDO::FETCH_ASSOC);
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

                <div class="card" style="width: 500px">
                    <div class="card-body" >
                        <div style="width: 100%; position: relative;">
                            <?php if (count($salesData) > 0) : ?>
                                <canvas id="donutChartContainer" style="height: 300px;"></canvas>
                            <?php else : ?>
                                <p>No data found</p>
                            <?php endif; ?>
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
            <?php if (count($salesData) > 0) : ?>
                // Data for the donut chart
                var donutChartData = {
                    labels: <?php echo json_encode(array_column($salesData, 'product_name')); ?>,
                    datasets: [{
                        data: <?php echo json_encode(array_column($salesData, 'total_quantity')); ?>,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66ff66', '#ff9966','#34e3fd','	#fce630','#3B3BFF','#A530FF'
                    ,'#613191'],
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
                            text: 'Donut Sales Count Graph',
                        },
                    },
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>
