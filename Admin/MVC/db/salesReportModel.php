<?php
include "config.php";


function getSalesmanReport($filter = 'today'){
    global $conn;

    $where = "";
    if($filter === 'today'){
        $where = "WHERE DATE(created_at) = CURDATE()";
    } elseif($filter === '7days'){
        $where = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    } elseif($filter === 'month'){
        $where = "WHERE MONTH(created_at) = MONTH(CURDATE())
                  AND YEAR(created_at) = YEAR(CURDATE())";
    }

    $sql = "
        SELECT 
            salesman_email,
            COUNT(id) AS total_bills,
            SUM(grand_total) AS total_sales
        FROM sales
        $where
        GROUP BY salesman_email
        ORDER BY total_sales DESC
    ";

    return $conn->query($sql);
}


function getSalesSummary($filter='today'){
    global $conn;

    $where = "";
    if($filter === 'today'){
        $where = "WHERE DATE(created_at) = CURDATE()";
    }

    $sql = "
        SELECT 
            SUM(grand_total) AS total_sales,
            COUNT(id) AS total_bills
        FROM sales
        $where
    ";

    return $conn->query($sql)->fetch_assoc();
}
