<!DOCTYPE html>
<html>
<head>
    <title>Product Variation Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Product Variation Dashboard</h2>

    <h3>Summary</h3>
    <ul>
        <li>Total Products: <strong><?php echo $totalResults; ?></strong></li>
    </ul>

    <h3>Variations Per Product</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Number of Variations</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $paginatedResults->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['variation_count']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>"<?php if ($i == $page) echo ' style="font-weight: bold;"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php } ?>
    </div>
<h3>Variations Per Product (Chart)</h3>
<canvas id="variationsChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('variationsChart').getContext('2d');

    const chartData = {
        labels: [
            <?php 
            // Prepare product names for chart labels
            $paginatedResults->data_seek(0); // Reset result pointer
            while ($row = $paginatedResults->fetch_assoc()) {
                echo '"' . $row['product_name'] . '",';
            }
            ?>
        ],
        datasets: [{
            label: 'Number of Variations',
            data: [
                <?php
                // Prepare variation counts for chart data
                $paginatedResults->data_seek(0); // Reset result pointer again
                while ($row = $paginatedResults->fetch_assoc()) {
                    echo $row['variation_count'] . ',';
                }
                ?>
            ],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    const variationsChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
