<!DOCTYPE html>
<html>
<head>
    <title>Manage Attributes</title>
</head>
<body>
    <h2>Manage Attributes</h2>
    <a href="/attributes/create">Add Attribute</a>
    <table border="1">
        <tr><th>Attribute Name</th><th>Sort Order</th></tr>
        <?php while ($row = $attributes->fetch_assoc()) {
            echo "<tr><td>{$row['attribute_name']}</td><td>{$row['sort_order']}</td></tr>";
        } ?>
    </table>
</body>
</html>
