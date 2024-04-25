<?php
include("connect.php");

$minPrice = $_POST["minPrice"];
$maxPrice = $_POST["maxPrice"];

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

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<items>'; 

foreach ($res as $row) {
    echo '<item>';
    echo '<name>' . $row['name'] . '</name>';
    echo '<price>' . $row['price'] . '</price>';
    echo '<quantity>' . $row['quantity'] . '</quantity>';
    echo '<quality>' . $row['quality'] . '</quality>';
    echo '<vendor>' . $row['vendor'] . '</vendor>';
    echo '<category>' . $row['category'] . '</category>';
    echo '</item>';
}

echo '</items>'; 