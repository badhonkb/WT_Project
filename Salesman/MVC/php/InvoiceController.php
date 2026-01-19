<?php
session_start();
include "../db/invoiceModel.php";

if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../Admin/MVC/html/login.php");
    exit();
}


if(isset($_GET['action']) && $_GET['action'] == 'fetch') {
    $filter = $_GET['filter'] ?? 'today';
    $search = $_GET['search'] ?? '';
    $invoices = getInvoices($filter, $search);

    if($invoices->num_rows > 0) {
        while($row = $invoices->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['total']}</td>
                    <td>{$row['discount']}</td>
                    <td>{$row['grand_total']}</td>
                    <td>
                        <button class='view-btn' data-id='{$row['id']}'>View</button>
                        <button class='print-btn' data-id='{$row['id']}'>Print</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No invoices found</td></tr>";
    }
    exit();
}


if(isset($_GET['action']) && $_GET['action'] == 'details' && isset($_GET['id'])) {
    $details = getInvoiceDetails($_GET['id']);

    $itemsArr = [];
    while($item = $details['items']->fetch_assoc()) {
        $itemsArr[] = $item;
    }

    echo json_encode(['sale' => $details['sale'], 'items' => $itemsArr]);
    exit();
}
?>
