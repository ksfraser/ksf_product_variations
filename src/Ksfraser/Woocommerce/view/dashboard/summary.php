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
    </style>
</head>
<body>
    <h2>Product Variation Dashboard</h2>

    <h3>Summary</h3>
    <ul>
        <li>Total Attributes: <strong><?php echo $totalAttributes; ?></strong></li>
        <li>Total Attribute Values: <strong><?php echo $totalAttributeValues; ?></strong></li>
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
            <?php while ($row = $variationsByProduct->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['variation_count']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
