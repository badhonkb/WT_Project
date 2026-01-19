<?php
include "config.php";


function getExpiredMedicines() {
    global $conn;
    $sql = "SELECT * FROM medicine 
            WHERE expiry_date < CURDATE()";
    return $conn->query($sql);
}


function getNearExpiryMedicines() {
    global $conn;
    $sql = "SELECT * FROM medicine 
            WHERE expiry_date BETWEEN CURDATE() 
            AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
    return $conn->query($sql);
}


function getOutOfStockMedicines() {
    global $conn;
    $sql = "SELECT * FROM medicine WHERE quantity = 0";
    return $conn->query($sql);
}
function getLowStockMedicines() {
    global $conn;
    $sql = "SELECT * FROM medicine WHERE quantity <= 10";
    return $conn->query($sql);
}
?>
