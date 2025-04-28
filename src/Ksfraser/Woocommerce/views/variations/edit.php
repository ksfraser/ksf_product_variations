<!DOCTYPE html>
<html>
<head>
    <title>Edit Product Variation</title>
</head>
<body>
    <h2>Edit Product Variation</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $variation['id']; ?>">
        <label>Stock ID:</label>
        <input type="text" name="new_stock_id" value="<?php echo $variation['variation_stock_id']; ?>" required>
        <label>Attributes (JSON format):</label>
        <textarea name="attribute_values"><?php echo json_encode($variation['attribute_values']); ?></textarea>
        <button type="submit">Update Variation</button>
    </form>
</body>
</html>
