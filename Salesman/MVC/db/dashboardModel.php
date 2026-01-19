<?php
include "config.php";


function getTodayTotalSale() {
    global $conn;
    $sql = "
        SELECT IFNULL(SUM(grand_total),0) AS total
        FROM sales
        WHERE DATE(created_at) = CURDATE()
    ";
    $res = $conn->query($sql);
    return $res->fetch_assoc()['total'];
}


function getTodayTotalBills() {
    global $conn;
    $sql = "
        SELECT COUNT(*) AS total
        FROM sales
        WHERE DATE(created_at) = CURDATE()
    ";
    $res = $conn->query($sql);
    return $res->fetch_assoc()['total'];
}


function getTopSellingMedicinesToday() {
    global $conn;
    $sql = "
        SELECT m.name, SUM(si.quantity) AS total_qty
        FROM sale_items si
        JOIN sales s ON s.id = si.sale_id
        JOIN medicine m ON m.id = si.medicine_id
        WHERE DATE(s.created_at) = CURDATE()
        GROUP BY si.medicine_id
        ORDER BY total_qty DESC
        LIMIT 5
    ";
    return $conn->query($sql);
}
