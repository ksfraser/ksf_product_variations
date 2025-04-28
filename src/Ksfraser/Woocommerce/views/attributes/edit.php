<!DOCTYPE html>
<html>
<head>
    <title>Edit Attribute</title>
</head>
<body>
    <h2>Edit Attribute</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $attribute['id']; ?>">
        <label>Attribute Name:</label>
        <input type="text" name="attribute_name" value="<?php echo $attribute['attribute_name']; ?>" required>
        <label>Sort Order:</label>
        <input type="number" name="sort_order" value="<?php echo $attribute['sort_order']; ?>" required>
        <button type="submit">Update Attribute</button>
    </form>
</body>
</html>
