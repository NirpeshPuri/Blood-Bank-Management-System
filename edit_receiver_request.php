<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'receiver') {
    header("Location: index.html"); 
    exit();
}

if (!isset($_GET['req_id'])) {
    echo "<script>alert('Request ID not provided.'); </script>";
    exit();
}

$requestId = $_GET['req_id'];

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM make_request WHERE req_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requestId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    echo "<script>alert('Blood request not found for ID: $requestId'); window.location.href='edit_receiver_request.php';</script>";
    exit();
}

$requestData = $result->fetch_assoc();

if ($requestData['status'] === 'approved') {
    echo "<script>alert('Cannot edit an approved request.'); window.location.href='receiver_status.php';</script>";
    exit();
}
if ($requestData['status'] === 'rejected') {
    echo "<script>alert('Cannot edit an rejected request.'); window.location.href='receiver_status.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bloodType = $_POST["blood_type"];
    $quantity = $_POST["quantity"];

    $updateSql = "UPDATE make_request SET blood_type=?, blood_quantity=? WHERE req_id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sii", $bloodType, $quantity, $requestId);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "<script>alert('Request updated successfully');</script>";
        echo "<script>window.location.href='receiver_status.php';</script>";
    } else {
        echo "<script>alert('Failed to update request.'); window.location.href='edit_receiver_request.php?req_id=$requestId';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blood Request</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="number"],
        select {
            width: calc(100% - 20px); 
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
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
    <h2>Edit Blood Request</h2>
    <form action="" method="post">
        <label for="blood_type">Blood Type:</label>
        <select name="blood_type" id="blood_type">
            <option value="A-" <?php if ($requestData['blood_type'] === 'A-') echo 'selected'; ?>>A-</option>
            <option value="A+" <?php if ($requestData['blood_type'] === 'A+') echo 'selected'; ?>>A+</option>
            <option value="B+" <?php if ($requestData['blood_type'] === 'B+') echo 'selected'; ?>>B+</option>
            <option value="B-" <?php if ($requestData['blood_type'] === 'B-') echo 'selected'; ?>>B-</option>
            <option value="AB+" <?php if ($requestData['blood_type'] === 'AB+') echo 'selected'; ?>>AB+</option>
            <option value="AB-" <?php if ($requestData['blood_type'] === 'AB-') echo 'selected'; ?>>AB-</option>
            <option value="O+" <?php if ($requestData['blood_type'] === 'O+') echo 'selected'; ?>>O+</option>
            <option value="O-" <?php if ($requestData['blood_type'] === 'O-') echo 'selected'; ?>>O-</option>
        </select>

        <label for="quantity">Quantity (unit):</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $requestData['blood_quantity']; ?>"
               required min="1" max="10">

        <input type="submit" value="Update Request">
        <a href="receiver_status.php">Go back to status</a>
    </form>
</div>
</body>
</html>
