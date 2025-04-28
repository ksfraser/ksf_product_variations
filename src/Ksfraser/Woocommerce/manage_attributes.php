<?php
include('includes/session.php');
$page_title = "Manage Product Attributes";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attribute_name = $_POST['attribute_name'];
    $sort_order = $_POST['sort_order'];

    $sql = "INSERT INTO fa_product_attributes (attribute_name, sort_order) VALUES ('$attribute_name', $sort_order)";
    db_query($sql);
}

$result = db_query("SELECT * FROM fa_product_attributes ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
</head>
<body>
    <h2>Manage Product Attributes</h2>
    <form method="post">
        <label>Attribute Name:</label>
        <input type="text" name="attribute_name" required>
        <label>Sort Order:</label>
        <input type="number" name="sort_order" required>
        <button type="submit">Add Attribute</button>
    </form>

    <h3>Existing Attributes</h3>
    <table border="1">
        <tr><th>Attribute Name</th><th>Sort Order</th></tr>
        <?php while ($row = db_fetch_assoc($result)) {
            echo "<tr><td>{$row['attribute_name']}</td><td>{$row['sort_order']}</td></tr>";
        } ?>
    </table>
</body>
</html>
