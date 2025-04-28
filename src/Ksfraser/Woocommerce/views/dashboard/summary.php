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

    <form method="get" action="/dashboard/filteredSummary">
        <h3>Filters</h3>
        <label>Min Variation Count:</label>
        <input type="number" name="minCount" min="0">
        <label>Max Variation Count:</label>
        <input type="number" name="maxCount" min="0">

        <label>Filter by Attribute:</label>
        <select name="attributeId">
            <option value="">-- Select Attribute --</option>
            <?php while ($attribute = $attributes->fetch_assoc()) {
                echo "<option value='{$attribute['id']}'>{$attribute['attribute_name']}</option>";
            } ?>
        </select>

        <label>Stock Status:</label>
        <select name="inStock">
            <option value="">-- Select Stock Status --</option>
            <option value="1">In Stock</option>
            <option value="0">Out of Stock</option>
        </select>

        <button type="submit">Apply Filters</button>
    </form>

    <h3>Summary</h3>
    <ul>
        <li>Total Attributes: <strong><?php echo $totalAttributes; ?></strong></li>
        <li>Total Attribute Values: <strong><?php echo $totalAttributeValues; ?></strong></li>
    </ul>

    <h3>Filtered Results</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Number of Variations</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $filteredVariations->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['variation_count']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
