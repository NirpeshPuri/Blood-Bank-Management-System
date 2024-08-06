<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "blood_bank");
    
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $blood_type = $_POST["blood_type"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];
    $user_type = $_POST["user_type"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate name: should contain only alphabets and optionally end with numbers
    if (!preg_match("/^[a-zA-Z]+[0-9]*$/", $name)) {
        echo "<script>alert('Name should contain only alphabets and optionally end with numbers.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }

    // Validate address: should contain only alphabets, numbers, spaces, commas, apostrophes, and hyphens
    if (!preg_match("/^[a-zA-Z]+[a-zA-Z0-9\s,'-]*$/", $address)) {
        echo "<script>alert('Address should start with alphabets and may contain alphabets, numbers, spaces, commas, apostrophes, and hyphens.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }
    
    // Validate phone: should be 10 digits
    if (!preg_match("/^\d{10}$/", $phone)) {
        echo "<script>alert('Phone should be 10 digits.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }

    // Validate age: should be between 16 and 65
    if ($age < 16 || $age > 65) {
        echo "<script>alert('Age should be between 16 and 65.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }

    // Validate weight: should be 45kg or more
    if ($weight < 45 || $weight>500) {
        echo "<script>alert('Weight should be 45kg or more.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }

    // Validate email: should have correct format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }

    // Password validation
    if (strlen($password) < 4 || !preg_match('/[!@#$%^&*]/', $password)) {
        echo "<script>alert('Password should be at least 4 characters long and contain at least 1 symbolic character.');</script>";
        echo "<script>window.location = 'register.php?" . http_build_query($_POST) . "';</script>";
        exit();
    }
    // SQL query for registration
    $sql = "INSERT INTO user (name, address, phone, blood_type, age, weight, user_type, email, password) 
            VALUES ('$name', '$address', '$phone', '$blood_type', '$age', '$weight', '$user_type', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style/register.css">
</head>
<body>
    <div class="container">
        <div class="form-box"><br><br><br><br><br><br><br>
            <header>Registration</header>
            <form action="register.php" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?php echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="blood_type">Blood Type</label>
                    <select name="blood_type" id="blood_type" required>
                        <option value="">Select</option>
                        <option value="A+" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                        <option value="A-" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                        <option value="B+" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                        <option value="B-" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                        <option value="AB+" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                        <option value="AB-" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                        <option value="O+" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                        <option value="O-" <?php echo isset($_GET['blood_type']) && $_GET['blood_type'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo isset($_GET['age']) ? htmlspecialchars($_GET['age']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" name="weight" id="weight" value="<?php echo isset($_GET['weight']) ? htmlspecialchars($_GET['weight']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="user_type">User Type</label>
                    <select name="user_type" id="user_type" required>
                        <option value="receiver" <?php echo isset($_GET['user_type']) && $_GET['user_type'] === 'receiver' ? 'selected' : ''; ?>>Receiver</option>
                        <option value="donor" <?php echo isset($_GET['user_type']) && $_GET['user_type'] === 'donor' ? 'selected' : ''; ?>>Donor</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="field">
                    <input type="submit" name="submit" value="Register">
                </div>
                <div class="links">
                    Already have an account? <a href="index.html">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
