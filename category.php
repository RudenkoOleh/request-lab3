<?php
include("connect.php");

$category = $_POST["category"];

$SELECT = "SELECT items.name, items.price, items.quantity, items.quality,vendors.v_name as vendor, category.c_name as category FROM items
JOIN category ON category.ID_Category = items.FID_Category
JOIN vendors ON vendors.ID_Vendors = items.FID_Vendor
WHERE category.c_name = :category";

try {
    $stmt = $dbh->prepare($SELECT);
    $stmt->bindValue(":category", $category);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($res);
} catch (PDOException $ex) {
    echo $ex->GetMessage();
}