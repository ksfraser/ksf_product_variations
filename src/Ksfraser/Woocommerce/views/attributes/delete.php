<!DOCTYPE html>
<html>
<head>
    <title>Delete Attribute</title>
</head>
<body>
    <h2>Delete Attribute</h2>
    <p>Are you sure you want to delete <strong><?php echo $attribute['attribute_name']; ?></strong>?</p>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $attribute['id']; ?>">
        <button type="submit">Confirm Delete</button>
    </form>
</body>
</html>
