<?php
include("connect.php");

$minPrice = $_GET["minPrice"];
$maxPrice = $_GET["maxPrice"];

$SELECT = "SELECT items.name, items.price, items.quantity, items.quality,vendors.v_name as vendor, category.c_name as category FROM items
JOIN vendors ON vendors.ID_Vendors = items.FID_Vendor
JOIN category ON category.ID_Category = items.FID_Category
WHERE items.price BETWEEN :minPrice AND :maxPrice";

try {
    $stmt = $dbh->prepare($SELECT);
    $stmt->bindValue(":minPrice", $minPrice);
    $stmt->bindValue(":maxPrice", $maxPrice);
    $stmt->execute();

    $res = $stmt->fetchAll();
} catch (PDOException $ex) {
    echo $ex->GetMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items by Price Range</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #d4d4d4;
        }
    </style>
</head>
<body>

<h2>Items in Price Range <?php echo $minPrice; ?> - <?php echo $maxPrice; ?></h2>

<table>
    <thead>
        <tr>
        <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Quality</th>
            <th>Vendor</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($res as $row): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['quality']; ?></td>
                <td><?php echo $row['vendor']; ?></td>
                <td><?php echo $row['category']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
