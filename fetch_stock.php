<?php
$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT blood_type, SUM(blood_quantity) AS total_quantity FROM stock_blood GROUP BY blood_type";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['blood_type'] . "</td><td>" . $row['total_quantity'] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>No blood stock available</td></tr>";
}

$conn->close();
?>
