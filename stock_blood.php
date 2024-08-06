<?php
session_start();

// Check if the user is not logged in or is not an admin, then redirect to login page
if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['add_to_stock'])){
        $blood_type = $_POST['blood_type'];
        $blood_quantity = $_POST['blood_quantity'];

        $sql_check = "SELECT * FROM stock_blood WHERE blood_type = '$blood_type'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_quantity = $row['blood_quantity'];
            $updated_quantity = $existing_quantity + $blood_quantity;

            $sql_update = "UPDATE stock_blood SET blood_quantity = $updated_quantity WHERE blood_type = '$blood_type'";
            if ($conn->query($sql_update) === TRUE) {
                echo "<script>alert('Record updated successfully'); window.location.href = 'stock_blood.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating record: ".$conn->error."'); window.location.href = 'stock_blood.php';</script>";
                exit();
            }
        } else {
            $sql_insert = "INSERT INTO stock_blood (blood_type, blood_quantity) VALUES ('$blood_type', '$blood_quantity')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "<script>alert('New record added successfully'); window.location.href = 'stock_blood.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error adding new record: ".$conn->error."'); window.location.href = 'stock_blood.php';</script>";
                exit();
            }
        }
    } elseif(isset($_POST['deduct_from_stock'])){
        $blood_type = $_POST['blood_type'];
        $blood_quantity = $_POST['blood_quantity'];

        $sql_check = "SELECT * FROM stock_blood WHERE blood_type = '$blood_type'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_quantity = $row['blood_quantity'];
            $updated_quantity = $existing_quantity - $blood_quantity;

            if($updated_quantity < 0){
                echo "<script>alert('Error: Cannot deduct more than the available quantity'); window.location.href = 'stock_blood.php';</script>";
                exit();
            }

            $sql_update = "UPDATE stock_blood SET blood_quantity = $updated_quantity WHERE blood_type = '$blood_type'";
            if ($conn->query($sql_update) === TRUE) {
                echo "<script>alert('Record updated successfully'); window.location.href = 'stock_blood.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating record: ".$conn->error."'); window.location.href = 'stock_blood.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Error: Blood type not found in stock'); window.location.href = 'stock_blood.php';</script>";
            exit();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Stock Management</title>
    <style>
        /* styles.css */
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

        .add-button {
    background-color: #4CAF50; 
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

.add-button:hover {
    background-color: #45a049; 
}

.deduct-button {
    background-color: #ff3333; 
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

.deduct-button:hover {
    background-color: #e60000; 
}


    </style>
</head>
<body>
<div class="container">
    <h2>Blood Stock Management</h2>

    <form action="stock_blood.php" method="post">
        <label for="blood_type">Blood Type:</label>
        <select name="blood_type" id="blood_type" required>
            <?php
            include_once('blood_type.php');

            foreach ($bloodTypes as $key => $value) {
                echo "<option value='$key'>$value</option>";
            }
            ?>
        </select>

        <label for="blood_quantity">Quantity (unit):</label>
        <input type="number" name="blood_quantity" id="blood_quantity" required min="1" max='100' required>

        <input type="submit" name="add_to_stock" value="Add to Stock" class="add-button">
<input type="submit" name="deduct_from_stock" value="Deduct from Stock" class="deduct-button">

    </form>

    <h3>Blood Stock:</h3>
    <table>
        <tr>
            <th>Blood Type</th>
            <th>Quantity (unit)</th>
        </tr>
        <?php
        include_once('fetch_stock.php');
        ?>
    </table>

    <a href="admin_dashboard.php">Go Back to Dashboard</a>
</div>
</body>
</html>
