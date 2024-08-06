<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'donor') {
    header("Location: index.html"); 
    exit();
}

$donor = $_SESSION['name'];

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user WHERE name='$donor'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $bloodType = $row["blood_type"];
    $donorPhone = $row["phone"]; 
    $address=$row['address'];
} else {
    echo "Donor not found";
    exit();
}

$conn->close();
?>
<?php include_once('donor/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="style/donor1.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo $donor; ?></h2><br><br>
        </div>
        <div class="dashboard-content">
            <div class="form-box">
                <h2>Donate Blood</h2>
                <form action="donate_blood.php" method="post" enctype="multipart/form-data" onsubmit="return validateDateTime()">
                    <div class="field input">
                        <label for="name">User name</label>
                        <input type="text" name="name" id="name" value="<?php echo $donor; ?>" readonly>
                    </div>
                    <div class="field input">
                        <label for="donor_phone">Donor Phone</label>
                        <input type="tel" name="donor_phone" id="donor_phone" value="<?php echo $donorPhone; ?>" readonly>
                    </div>
                    <div class="field input">
                        <label for="donor_card">Upload Donor Card or Driving License</label>
                        <input type="file" name="donor_card" id="donor_card" accept="image/*,application/pdf" required>
                    </div>
                    <div class="field input">
                        <label for="blood_quantity">Blood Quantity (unit)</label>
                        <input type="number" name="blood_quantity" id="blood_quantity" required min="1" max="10" required>
                    </div>
                    <div class="field input">
                        <label for="blood_date_time">Date and Time</label>
                        <input type="datetime-local" name="blood_date_time" id="blood_date_time" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                    </div>
                    <div class="field input">
                        <label for="blood_type">Blood Type</label>
                        <input type="text" name="blood_type" id="blood_type" value="<?php echo $bloodType; ?>" readonly>
                    </div>
                    <div class="field">
                        <input type="submit" name="submit" value="Donate Blood">
                    </div>
                </form>
            </div>
            <div class="blood-quantity">
                <p>Your blood type: <?php echo $bloodType; ?></p>
                <p>Phone number: <?php echo $donorPhone; ?></p>
                <p>Address : <?php echo $address; ?></p>
            </div>
        </div>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
            <br><br><br><br><br><br>
        </div>
    </div>
    <script>
        function validateDateTime() {
            var selectedDateTime = new Date(document.getElementById("blood_date_time").value);
            var currentDateTime = new Date();
            var fiveMinutesAgo = new Date(currentDateTime.getTime() - 5 * 60000); // 5 minutes ago
            var fiveMinutesLater = new Date(currentDateTime.getTime() + 5 * 60000); // 5 minutes later
            if (selectedDateTime < fiveMinutesAgo || selectedDateTime > fiveMinutesLater) {
                alert("Please select a datetime within 5 minutes from now.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php include_once('donor/footer.php'); ?>

