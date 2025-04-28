<!DOCTYPE html>
<html>
<head>
    <title>Preview Variations</title>
    <script>
        function collectEditedData() {
            const editedVariations = [];
            document.querySelectorAll('.editable-row').forEach(row => {
                editedVariations.push({
                    original_stock_id: row.dataset.originalStockId,
                    stock_id: row.querySelector('.stock-id').value,
                    description: row.querySelector('.description').value
                });
            });

            // Store JSON-encoded data in a hidden input field
            document.getElementById('edited_variations').value = JSON.stringify(editedVariations);
        }
    </script>
</head>
<body>
    <h2>Preview & Edit Generated Variations</h2>

    <form method="post" action="/variations/saveEditedVariations" onsubmit="collectEditedData()">
        <table border="1">
            <thead>
                <tr>
                    <th>Stock ID (Editable)</th>
                    <th>Short Description (Editable)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($variations as $variation) { ?>
                    <tr class="editable-row" data-original-stock-id="<?php echo $variation['stock_id']; ?>">
                        <td>
                            <input type="text" class="stock-id" value="<?php echo $variation['stock_id']; ?>" required>
                        </td>
                        <td>
                            <input type="text" class="description" value="<?php echo $variation['description']; ?>" required>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Hidden input to store JSON-encoded edited data -->
        <input type="hidden" id="edited_variations" name="edited_variations">

        <button type="submit">Final Save</button>
        <button type="button" onclick="window.history.back();">Go Back</button>
    </form>
</body>
</html>
