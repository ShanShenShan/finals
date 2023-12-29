<?php require "../includes/header.php"; ?>
<?php require "../config/connection.php"; ?>
<?php require "../includes/redirecting.php"; ?>
<?php require "../includes/sidebar.php"; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Adjust the end date to cover the entire day
    $endDate = date('Y-m-d', strtotime($endDate));

    $search = $connection->prepare("SELECT i.product_name, SUM(tp.quantity) as total_quantity
                                     FROM transaction_products tp
                                     JOIN inventory i ON tp.product_id = i.id
                                     JOIN transaction_records tr ON tp.tr_id = tr.id
                                     WHERE tr.tr_date >= :start_date AND tr.tr_date < :end_date
                                     GROUP BY tp.product_id");
    $search->bindParam(":start_date", $startDate);
    $search->bindParam(":end_date", $endDate);
    $search->execute();

    $salesData = $search->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Default query without date filtering
    $search = $connection->query("SELECT i.product_name, SUM(tp.quantity) as total_quantity
                                 FROM transaction_products tp
                                 JOIN inventory i ON tp.product_id = i.id
                                 JOIN transaction_records tr ON tp.tr_id = tr.id
                                 GROUP BY tp.product_id");
    $search->execute();

    $salesData = $search->fetchAll(PDO::FETCH_ASSOC);
}
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
                        <div name="graph-tQuantity" style="width: 50%; position: relative;">
                            <?php if (count($salesData) > 0) : ?>
                                <canvas id="donutChartContainer" style="height: 300px;"></canvas>
                            <?php else : ?>
                                <p>No data found</p>
                            <?php endif; ?>
                        </div>

                        <div name="tQuantityFilter" style="width: 50%; position: relative;">
                        <!-- Date Filter Form -->
                        <form method="POST" action="">
                            <label for="start_date">Start:</label>
                                <input type="date" name="start_date" id="start_date" value="<?php echo isset($startDate) ? $startDate : ''; ?>">
                            <br><label for="end_date">End:</label>
                                <input type="date" name="end_date" id="end_date" value="<?php echo isset($endDate) ? $endDate : ''; ?>">
                                <button type="submit">Filter</button>
                                <button type="button" onclick="resetDates()">Reset</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "../includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function resetDates() {
            // Get the current year
            var currentYear = new Date().getFullYear();

            // Set the start date to the beginning of the current year
            document.getElementById("start_date").value = currentYear + "-01-01";

            // Set the end date to the end of the current year
            document.getElementById("end_date").value = currentYear + "-12-31";
        }

        document.addEventListener("DOMContentLoaded", function () {
            <?php if (count($salesData) > 0) : ?>
                // Data for the donut chart
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
                            text: 'Donut Sales Count Graph',
                        },
                    },
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>
