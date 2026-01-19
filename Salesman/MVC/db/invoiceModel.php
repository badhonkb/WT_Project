<?php
include "config.php";


function getInvoices($filter = 'today', $search = '') {
    global $conn;
    $where = [];
    
 
    if ($filter == 'today') {
        $where[] = "s.created_at >= CURDATE()";
    } elseif ($filter == '7days') {
        $where[] = "s.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    } elseif ($filter == '30days') {
        $where[] = "s.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
    }

    
    if(!empty($search)) {
        $search = $conn->real_escape_string($search);
        $where[] = "(c.name LIKE '%$search%' OR c.phone LIKE '%$search%')";
    }

    $where_sql = '';
    if(count($where) > 0) {
        $where_sql = "WHERE " . implode(" AND ", $where);
    }

    $sql = "SELECT s.id, c.name as customer_name, c.phone, s.total, s.discount, s.grand_total, s.created_at
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            $where_sql
            ORDER BY s.id DESC";
    
    return $conn->query($sql);
}


function getInvoiceDetails($sale_id) {
    global $conn;
    $sale_id = (int)$sale_id;

    $sql = "SELECT s.*, c.name as customer_name, c.phone
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            WHERE s.id = $sale_id";
    $sale = $conn->query($sql)->fetch_assoc();

    $sql_items = "SELECT si.*, m.name, m.generic_name, m.company_name
                  FROM sale_items si
                  JOIN medicine m ON si.medicine_id = m.id
                  WHERE si.sale_id = $sale_id";
    $items = $conn->query($sql_items);

    return ['sale' => $sale, 'items' => $items];
}
?>
