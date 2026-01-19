<?php
include "config.php";

function getSalesmen() {
    global $conn;
    $sql = "SELECT DISTINCT salesman_email FROM sales ORDER BY salesman_email";
    return $conn->query($sql);
}

function getCommissionReport($days, $email = null) {
    global $conn;

    $condition = "";
    if ($email) {
        $condition .= " AND salesman_email = '$email'";
    }

    $sql = "
        SELECT 
            id,
            salesman_email,
            grand_total,
            (grand_total * 0.05) AS commission,
            created_at
        FROM sales
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL $days DAY)
        $condition
        ORDER BY created_at DESC
    ";

    return $conn->query($sql);
}
