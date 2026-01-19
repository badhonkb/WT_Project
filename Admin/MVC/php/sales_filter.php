<?php
require_once "config.php";

$date = $_POST['date'];

$sql = "SELECT salesman_email, SUM(grand_total) total, COUNT(*) bills
        FROM sales
        WHERE DATE(created_at)=?
        GROUP BY salesman_email
        ORDER BY total DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$date);
$stmt->execute();
$result = $stmt->get_result();

echo "<h4>Sales Report ($date)</h4>";
echo "<table border='1' width='100%'>";
echo "<tr><th>Salesman</th><th>Total Sales</th><th>Bills</th></tr>";

while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>{$row['salesman_email']}</td>
            <td>৳ {$row['total']}</td>
            <td>{$row['bills']}</td>
          </tr>";
}
echo "</table>";
