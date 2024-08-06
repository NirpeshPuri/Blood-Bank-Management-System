<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'receiver') {
    header("Location: index.html"); 
    exit();
}

$receiver = $_SESSION['name'];

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user WHERE name='$receiver'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingName = $row['name'];
    $existingAddress = $row['address'];
    $existingPhone = $row['phone'];
    $existingBloodType = $row['blood_type'];
    $existingAge = $row['age'];
    $existingWeight = $row['weight'];
    $existingEmail = $row['email'];
} else {
    echo "No user found";
    exit();
}

$nameError = $addressError = $phoneError = $bloodTypeError = $ageError = $weightError = $emailError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST["new_name"];
    $newAddress = $_POST["new_address"];
    $newPhone = $_POST["new_phone"];
    $newBloodType = $_POST["new_blood_type"];
    $newAge = $_POST["new_age"];
    $newWeight = $_POST["new_weight"];
    $newEmail = $_POST["new_email"];
    $newPassword = $_POST["new_password"];


    // Validate name: should contain only alphabets and optionally end with numbers
    if (!preg_match("/^[a-zA-Z]+[0-9]*$/", $newName)) {
        $nameError = "Name should contain only alphabets and optionally end with numbers.";
    } else {
        $existingName = $newName; // Set existingName to newName if it's valid
    }

    // Validate address: should start with alphabets and may contain alphabets, numbers, spaces, commas, apostrophes, and hyphens
    if (!preg_match("/^[a-zA-Z]+[a-zA-Z0-9\s,'-]*$/", $newAddress)) {
        $addressError = "Address should start with alphabets and may contain alphabets, numbers, spaces, commas, apostrophes, and hyphens.";
    } else {
        $existingAddress = $newAddress; // Set existingAddress to newAddress if it's valid
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

    // Validate age: should be between 16 and 65
    if ($newAge < 16 || $newAge > 65) {
        $ageError = "Age should be between 16 and 65.";
    } else {
        $existingAge = $newAge; // Set existingAge to newAge if it's valid
    }

    // Validate weight: should be 45kg or more
    if ($newWeight < 45) {
        $weightError = "Weight should be 45kg or more.";
    } else {
        $existingWeight = $newWeight; // Set existingWeight to newWeight if it's valid
    }

    // Password validation
    if (strlen($newPassword) < 4 || !preg_match('/[!@#$%^&*]/', $newPassword)) {
        $passwordError = "Password should be at least 4 characters long and contain at least 1 symbolic character.";
    }

    // If all validations pass, update the receiver's information in the database
    if ($nameError === "" && $addressError === "" && $phoneError === "" && $emailError === "" && $ageError === "" && $weightError === "" && $passwordError === "") {
        $sql = "UPDATE user SET name='$existingName', address='$existingAddress', phone='$existingPhone', blood_type='$newBloodType', age='$existingAge', weight='$existingWeight', email='$existingEmail' WHERE name='$receiver'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Profile updated successfully');</script>";
            echo "<script>window.location='edit_receiver_profile.php';</script>";
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
                        <label for="new_address">New Address</label>
                        <input type="text" name="new_address" id="new_address" required value="<?php echo $existingAddress; ?>">
                        <span class="error-message"><?php echo $addressError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_phone">New Phone</label>
                        <input type="text" name="new_phone" id="new_phone" required value="<?php echo $existingPhone; ?>">
                        <span class="error-message"><?php echo $phoneError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_blood_type">Blood Type</label>
                        <select name="new_blood_type" id="new_blood_type" required>
                             <option value="">Select</option>
                             <option value="A+" <?php echo ($existingBloodType == 'A+') ? 'selected' : ''; ?>>A+</option>
                             <option value="A-" <?php echo ($existingBloodType == 'A-') ? 'selected' : ''; ?>>A-</option>
                             <option value="B+" <?php echo ($existingBloodType == 'B+') ? 'selected' : ''; ?>>B+</option>
                             <option value="B-" <?php echo ($existingBloodType == 'B-') ? 'selected' : ''; ?>>B-</option>
                             <option value="AB+" <?php echo ($existingBloodType == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                             <option value="AB-" <?php echo ($existingBloodType == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                             <option value="O+" <?php echo ($existingBloodType == 'O+') ? 'selected' : ''; ?>>O+</option>
                             <option value="O-" <?php echo ($existingBloodType == 'O-') ? 'selected' : ''; ?>>O-</option>
                         </select>
                         <span class="error-message"><?php echo $bloodTypeError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_age">New Age</label>
                        <input type="number" name="new_age" id="new_age" required value="<?php echo $existingAge; ?>">
                        <span class="error-message"><?php echo $ageError; ?></span>
                    </div>

                    <div class="field input">
                        <label for="new_weight">New Weight</label>
                        <input type="number" name="new_weight" id="new_weight" required value="<?php echo $existingWeight; ?>">
                        <span class="error-message"><?php echo $weightError; ?></span>
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
        <a href="receiver_dashboard.php">Back to dashboard</a>
    </div>
</body>
</html>
