<!DOCTYPE html>
<html>
<head>
    <title>Bulk Edit Product Variations</title>
</head>
<body>
    <h2>Bulk Edit Product Variations</h2>
    <form method="post" action="/variations/bulkUpdate">
        <table border="1">
            <tr>
                <th>Select</th>
                <th>Stock ID</th>
                <th>Attributes (JSON)</th>
                <th>Updated At</th>
            </tr>
            <?php while ($variation = $variations->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <input type="checkbox" name="selected_variations[]" value="<?php echo $variation['id']; ?>">
                    </td>
                    <td>
                        <input type="text" name="new_stock_id[<?php echo $variation['id']; ?>]" value="<?php echo $variation['variation_stock_id']; ?>" required>
                    </td>
                    <td>
                        <textarea name="attribute_values[<?php echo $variation['id']; ?>]"><?php echo $variation['attribute_values']; ?></textarea>
                    </td>
                    <td><?php echo $variation['updated_at']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <button type="submit">Bulk Update</button>
    </form>

    <h2>Bulk Delete Product Variations</h2>
    <form method="post" action="/variations/bulkDelete">
        <label>Select Variations to Delete:</label>
        <select name="variation_ids[]" multiple>
            <?php while ($variation = $variations->fetch_assoc()) {
                echo "<option value='{$variation['id']}'>{$variation['variation_stock_id']}</option>";
            } ?>
        </select>
        <button type="submit">Bulk Delete</button>
    </form>
</body>
</html>
