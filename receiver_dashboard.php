<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'receiver') {
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

$conn->close();
?>
<?php include_once('receiver/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver Dashboard</title>
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
    <a href="logout.php" style="float: right;">logout</a>
        <h2>Welcome, <?php echo $user; ?></h2>

        <h3>Your Details:</h3>
        <p>Name: <?php echo $userData['name']; ?></p>
        <p>Email: <?php echo $userData['email']; ?></p>

        <h3>Blood Stock:</h3>
        <table>
            <tr>
                <th>Blood Type</th>
                <th>Quantity (unit)</th>
            </tr>
            <?php
            while ($row = $resultBloodStock->fetch_assoc()) {
                echo "<tr><td>" . $row['blood_type'] . "</td><td>" . $row['blood_quantity'] . "</td></tr>";
            }
            ?>
        </table>

        <h3>Make a Blood Request:</h3>
        <form action="make_request.php" method="post" enctype="multipart/form-data">
        <label for="name">User name</label>
        <input type="text" name="name" id="name" value="<?php echo $user; ?>" readonly>
    
            <label for="blood_type">Blood Type:</label>
            <select name="blood_type" id="blood_type">
                <option value="A-">A-</option>
                <option value="A+">A+</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            
            <label for="quantity">Quantity (unit):</label>
            <input type="number" name="quantity" id="quantity" required min="1" max="10" required>
            
             <label for="rec_card">Upload Receiver Request Form or Driving License</label>
            <input type="file" name="rec_card" id="rec_card" accept="image/*,application/pdf" required>
                

            <input type="submit" value="Request Blood">
        </form>

        <br><br>
    </div>
</body>
</html>
<?php include_once('receiver/footer.php'); ?>
