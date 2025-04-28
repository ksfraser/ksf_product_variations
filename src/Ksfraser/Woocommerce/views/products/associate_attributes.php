<!DOCTYPE html>
<html>
<head>
    <title>Associate Attributes with Product</title>
</head>
<body>
    <h2>Associate Attributes with Product</h2>
    <form method="post">
        <label>Select Product:</label>
        <select name="product_id">
            <!-- Fetch and populate products dynamically -->
            <?php while ($product = $products->fetch_assoc()) {
                echo "<option value='{$product['id']}'>{$product['name']}</option>";
            } ?>
        </select>

        <label>Select Attribute:</label>
        <select name="attribute_id">
            <!-- Fetch and populate attributes dynamically -->
            <?php while ($attribute = $attributes->fetch_assoc()) {
                echo "<option value='{$attribute['id']}'>{$attribute['attribute_name']}</option>";
            } ?>
        </select>

        <button type="submit">Associate Attribute</button>
    </form>
</body>
</html>
