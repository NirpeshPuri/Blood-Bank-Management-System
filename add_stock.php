<?php
$bloodType = $_POST["blood_type"];
$bloodQuantity = $_POST["blood_quantity"];

$conn = new mysqli("localhost", "root", "", "bbms3");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlCheckExisting = "SELECT * FROM stock_blood WHERE blood_type = '$bloodType'";
$result = $conn->query($sqlCheckExisting);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingQuantity = $row["blood_quantity"];
    $newQuantity = $existingQuantity + $bloodQuantity;

    $sqlUpdateQuantity = "UPDATE stock_blood SET blood_quantity = $newQuantity WHERE blood_type = '$bloodType'";
    if ($conn->query($sqlUpdateQuantity) === TRUE) {
        echo "Blood stock updated successfully";
    } else {
        echo "Error updating blood stock: " . $conn->error;
    }
} else {
    $sqlInsert = "INSERT INTO stock_blood (blood_type, blood_quantity) VALUES ('$bloodType', $bloodQuantity)";
    if ($conn->query($sqlInsert) === TRUE) {
        echo "Blood stock added successfully";
    } else {
        echo "Error adding blood stock: " . $conn->error;
    }
}

$conn->close();
?>
