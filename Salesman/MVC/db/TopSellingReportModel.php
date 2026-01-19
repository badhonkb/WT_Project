<?php
include "config.php";

function getTopSellingMedicines($filter) {
    global $conn;

    $where = "";

    if ($filter == 'today') {
        $where = "WHERE DATE(s.created_at) = CURDATE()";
    } elseif ($filter == 'month') {
        $where = "WHERE MONTH(s.created_at) = MONTH(CURDATE())
                  AND YEAR(s.created_at) = YEAR(CURDATE())";
    }

    $sql = "
        SELECT 
            m.name AS medicine_name,
            m.generic_name,
            m.company_name,
            SUM(si.quantity) AS total_sold
        FROM sale_items si
        JOIN sales s ON si.sale_id = s.id
        JOIN medicine m ON si.medicine_id = m.id
        $where
        GROUP BY si.medicine_id
        ORDER BY total_sold DESC
    ";

    return $conn->query($sql);
}
