<?php
    include("connect.php");

    $vendor = $_POST["vendor"];

    $SELECT = "SELECT items.name, items.price, items.quantity, items.quality, vendors.v_name as vendor, category.c_name as category FROM items
    JOIN vendors ON vendors.ID_Vendors = items.FID_Vendor
    JOIN category ON category.ID_Category = items.FID_Category
    WHERE vendors.v_name = :vendor";

    try {
        $stmt = $dbh->prepare($SELECT);
        $stmt->bindValue(":vendor", $vendor);
        $stmt->execute();

        $res = $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $ex->GetMessage();
    }
    
    foreach ($res as $row){
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['quality'] . "</td>";
        echo "<td>" . $row['vendor'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "</tr>";
    }
?>