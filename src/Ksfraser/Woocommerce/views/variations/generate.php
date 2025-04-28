<!DOCTYPE html>
<html>
<head>
    <title>Generate Product Variations</title>
</head>
<body>
    <h2>Generate Product Variations</h2>

    <form method="post" action="/variations/generateVariations">
        <label>Select Product:</label>
        <select name="product_id" required>
            <?php while ($product = $products->fetch_assoc()) { ?>
                <option value="<?php echo $product['stock_id']; ?>"><?php echo $product['description']; ?></option>
            <?php } ?>
        </select>

        <h3>Select Attributes</h3>
        <?php while ($attribute = $attributes->fetch_assoc()) { ?>
            <div>
                <label>
                    <input type="checkbox" name="attributes[]" value="<?php echo $attribute['id']; ?>">
                    <?php echo $attribute['attribute_name']; ?>
                </label>
            </div>
        <?php } ?>

        <button type="submit">Generate Variations</button>
    </form>
</body>
</html>
