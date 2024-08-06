<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.html"); 
    exit();
}

$admin = $_SESSION['name'];

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM admin WHERE name='$admin'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingName = $row['name'];
    $existingPhone = $row['phone'];
    $existingEmail = $row['email'];
} else {
    echo "No user found";
    exit();
}

$nameError = $addressError = $phoneError = $bloodTypeError = $ageError = $weightError = $emailError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST["new_name"];
    $newPhone = $_POST["new_phone"];
    $newEmail = $_POST["new_email"];
    $newPassword = $_POST["new_password"];

    // Validate name: should contain only alphabets and optionally end with numbers
    if (!preg_match("/^[a-zA-Z]+[0-9]*$/", $newName)) {
        $nameError = "Name should contain only alphabets and optionally end with numbers.";
    } else {
        $existingName = $newName; // Set existingName to newName if it's valid
    }

    // Validate phone: should be 10 digits
    if (!preg_match("/^\d{10}$/", $newPhone)) {
        $phoneError = "Phone should be 10 digits.";
    } else {
        $existingPhone = $newPhone; // Set existingPhone to newPhone if it's valid
    }

    // Validate email: should have correct format
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    } else {
        $existingEmail = $newEmail; // Set existingEmail to newEmail if it's valid
    }

    // Password validation
    if (strlen($newPassword) < 4 || !preg_match('/[!@#$%^&*]/', $newPassword)) {
        $passwordError = "Password should be at least 4 characters long and contain at least 1 symbolic character.";
    } 

    // If all validations pass, update the receiver's information in the database
    if ($nameError === "" && $phoneError === "" && $emailError === "" && $passwordError === "") {
        $sql = "UPDATE admin SET name='$existingName', phone='$existingPhone', email='$existingEmail', password='$newPassword' WHERE name='$admin'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Profile updated successfully');</script>";
            // Redirect to the same page to prevent resubmission of form data
            echo "<script>window.location='edit_admin_profile.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
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
    <title>Edit Profile</title>
    <lin rel="stylesheet" href="style/donor.css">
    <style>
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h2 {
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .form-box {
            margin-top: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #f00;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h2>Edit Profile</h2>
        </div>

        <div class="dashboard-content">
            <div class="form-box">
                <form action="" method="post" id="updateForm">
                    <div class="field input">
                        <label for="new_name">New Name</label>
                        <input type="text" name="new_name" id="new_name" required value="<?php echo $existingName; ?>">
                        <span class="error-message"><?php echo $nameError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_phone">New Phone</label>
                        <input type="text" name="new_phone" id="new_phone" required value="<?php echo $existingPhone; ?>">
                        <span class="error-message"><?php echo $phoneError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_email">New Email</label>
                        <input type="email" name="new_email" id="new_email" required value="<?php echo $existingEmail; ?>">
                        <span class="error-message"><?php echo $emailError; ?></span>
                    </div>
                    <div class="field input">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" ">
                        <span class="error-message"><?php echo $passwordError; ?></span>
                    </div>

                    <div class="field">
                        <input type="submit" name="submit" value="Update Profile">
                    </div>
                </form>
            </div>
        </div>
        <a href="admin_dashboard.php">Back to dashboard</a>
    </div>
</body>
</html>
