<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'donor') {
    header("Location: index.html"); 
    exit();
}

$user = $_SESSION['name'];

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlUser = "SELECT * FROM user WHERE name=?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $user);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows == 1) {
    $userData = $resultUser->fetch_assoc();
} else {
    echo "User not found";
    exit();
}

$sqlBloodStock = "SELECT * FROM stock_blood";
$resultBloodStock = $conn->query($sqlBloodStock);

$sqlReceiverRequests = "SELECT * FROM donate_blood WHERE name=?";
$stmtReceiverRequests = $conn->prepare($sqlReceiverRequests);
$stmtReceiverRequests->bind_param("s", $user);
$stmtReceiverRequests->execute();
$resultReceiverRequests = $stmtReceiverRequests->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Status</title>
    <style>
       
body {
    font-family: 'Arial', sans-serif;
    background-color: #f2f2f2;
    margin: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
}

h3 {
    color: #555;
}

p {
    margin: 10px 0;
    color: #666;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #333;
}

select, input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

a {
    display: block;
    margin-top: 20px;
    text-align: right;
    color: #4CAF50;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>  
<div class="container">
        <h3>Your Blood Requests:</h3>
        <table>
            <tr>
                <th>Blood Type</th>
                <th>Quantity (unit)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = $resultReceiverRequests->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['blood_type'] . "</td>";
                echo "<td>" . $row['blood_quantity'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td><a href='edit_donor_request.php?donate_id=" . $row['donate_id'] . "'>Edit Request</a><br>
                <a href='del_donor_own_req.php?donate_id=" . $row['donate_id'] . "'>Delete Request</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <a href="donor_dashboard.php">Go to dashboard</a>
        <br><br>
    </div>
</body>
</html>

