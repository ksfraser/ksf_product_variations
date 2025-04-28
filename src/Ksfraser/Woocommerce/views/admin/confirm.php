<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Screen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Attributes and Values Confirmed</h2>
    <p>The following attributes and values have been successfully inserted into the database:</p>

    <h3>Attributes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Attribute Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $attributes->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['attribute_name']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3>Attribute Values</h3>
    <table>
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $values->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['attribute_name']; ?></td>
                    <td><?php echo $row['value_name']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>
    <form action="/admin/dashboard">
        <button type="submit">Return to Dashboard</button>
    </form>
</body>
</html>
