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
                                     JOIN transaction_records tr ON tp.tran_id = tr.id
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
                                 JOIN transaction_records tr ON tp.tran_id = tr.id
                                 GROUP BY tp.product_id");
    $search->execute();

    $salesData = $search->fetchAll(PDO::FETCH_ASSOC);
}

$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

try {
    // Setting up a connection into the database using constants from connection.php
    $connection = new PDO("mysql:host=" . host . ";dbname=" . database, user, password);
    
    // Generating an error message
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Initialize arrays for all months with zero sales for both selected year and the previous year
    $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $quantitiesSelectedYear = array_fill(0, 12, 0); // Assuming 0-indexed months
    $quantitiesPreviousYear = array_fill(0, 12, 0); // Assuming 0-indexed months
    
    // Fetch data from the database for the selected year
    $sqlSelectedYear = "SELECT MONTH(tr_date) as month, SUM(quantity) as total_quantity
                        FROM transaction_records tr
                        JOIN transaction_products tp ON tr.id = tp.tran_id
                        WHERE YEAR(tr_date) = :selectedYear
                        GROUP BY MONTH(tr_date)";
    
    $stmtSelectedYear = $connection->prepare($sqlSelectedYear);
    $stmtSelectedYear->bindParam(':selectedYear', $selectedYear, PDO::PARAM_STR);
    $stmtSelectedYear->execute();
    
    // Fill in the actual sales data for the selected year
    while ($row = $stmtSelectedYear->fetch(PDO::FETCH_ASSOC)) {
        $month = $row['month'] - 1; // Adjust for 0-indexed array
        $quantitiesSelectedYear[$month] = $row['total_quantity'];
    }

    // Fetch data from the database for the previous year
    $previousYear = $selectedYear - 1;
    $sqlPreviousYear = "SELECT MONTH(tr_date) as month, SUM(quantity) as total_quantity
                        FROM transaction_records tr
                        JOIN transaction_products tp ON tr.id = tp.tran_id
                        WHERE YEAR(tr_date) = :previousYear
                        GROUP BY MONTH(tr_date)";
    
    $stmtPreviousYear = $connection->prepare($sqlPreviousYear);
    $stmtPreviousYear->bindParam(':previousYear', $previousYear, PDO::PARAM_STR);
    $stmtPreviousYear->execute();
    
    // Fill in the actual sales data for the previous year
    while ($row = $stmtPreviousYear->fetch(PDO::FETCH_ASSOC)) {
        $month = $row['month'] - 1; // Adjust for 0-indexed array
        $quantitiesPreviousYear[$month] = $row['total_quantity'];
    }

    // Find the maximum quantity for both years
    $maxQuantitySelectedYear = max($quantitiesSelectedYear);
    $maxQuantityPreviousYear = max($quantitiesPreviousYear);
    
    // Calculate the upper limit for the Y-axis (rounding off to the nearest tens) for both years
    $upperLimitSelectedYear = ceil($maxQuantitySelectedYear / 10) * 10;
    $upperLimitPreviousYear = ceil($maxQuantityPreviousYear / 10) * 10;
    
} catch (PDOException $error) {
    // Display the error message
    die("Connection has been failed miserably. Reason: " . $error->getMessage());
}
?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

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

                        <div class="donut">

                            <div name="donut-tQuantity" style="width: 100%; position: relative;">
                                <?php if (count($salesData) > 0) : ?>
                                    <canvas id="donutChartContainer" style="height: 3400px;"></canvas>
                                <?php else : ?>
                                    <p>No data found</p>
                                <?php endif; ?>
                            </div>

                            <div name="donutQuantityFilter" style="width: 100%; position: relative;">
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

                        <div class="bar">

                        <div name="bar-tQuantity" style="width: 100%; position: relative;">
                            <?php if (count($salesData) > 0) : ?>
                                <canvas id="salesChart" width="800" height="680"></canvas>
                            <?php else : ?>
                                <p>No data found</p>
                            <?php endif; ?>
                        </div>

                        <div name="barQuantityFilter" style="width: 100%; position: relative;">
                            <!-- Year selector -->
                            <form method="get">
                                <label for="year">Select Year:</label>
                                <select id="year" name="year" onchange="this.form.submit()">
                                    <?php
                                    // Generate options for the last few years
                                    $currentYear = date('Y');
                                    for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                                        echo "<option value=\"$i\" " . ($selectedYear == $i ? "selected" : "") . ">$i</option>";
                                    }   
                                    ?>
                                </select>
                            </form>
                        </div>

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
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66ff66', '#ff9966',
                                            '#34e3fd', '#fce630', '#3B3BFF', '#A530FF', '#613191',
                                            '#FF7F50', '#4CAF50', '#FFD700', '#FF69B4', '#8A2BE2',
                                            '#20B2AA', '#FF4500', '#32CD32', '#8B008B', '#5F9EA0',
                                            '#FF1493', '#2E8B57', '#9932CC', '#00FF7F', '#4682B4',
                                            '#8B4513', '#00FFFF', '#DC143C', '#00CED1', '#00FA9A',
                                            '#191970', '#8B0000', '#7B68EE', '#FFFF00', '#98FB98',
                                            '#00BFFF', '#7CFC00', '#FF6347', '#FA8072', '#FFDAB9',
                                            '#556B2F', '#8B008B', '#008080', '#8B4513',
                                            '#FFA07A', '#2F4F4F', '#8B4513', '#20B2AA', '#D8BFD8',
                                            '#FF4500', '#808000', '#8A2BE2', '#00FF00', '#000080',
                                            '#FAEBD7', '#FFD700', '#8B4513', '#2E8B57', '#FF6347',
                                            '#FFD700', '#4682B4', '#008080', '#556B2F', '#8B4513'],
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

        // Use Chart.js to create a bar graph
var ctx = document.getElementById('salesChart').getContext('2d');
var salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($monthNames); ?>,
        datasets: [{
            label: 'Quantity sold this year (' + <?php echo $selectedYear; ?> + ')',
            data: <?php echo json_encode($quantitiesSelectedYear); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }, {
            label: 'Previous year (' + <?php echo $previousYear; ?> + ')',
            data: <?php echo json_encode($quantitiesPreviousYear); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Different color for the previous year
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: <?php echo max($upperLimitSelectedYear, $upperLimitPreviousYear); ?> // Set the max value for the Y-axis
            }
        }
    }
});
    </script>
</body>

</html>
