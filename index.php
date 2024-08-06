<?php

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $userType = $_POST["type"];

    $query = "";

    switch ($userType) {
        case "receiver":
            $query = "SELECT * FROM user WHERE name='$name' AND password='$password' AND user_type='receiver'";
            break;
        case "donor":
            $query = "SELECT * FROM user WHERE name='$name' AND password='$password' AND user_type='donor'";
            break;
        case "admin":
            $query = "SELECT * FROM admin WHERE name='$name' AND password='$password'";
            break;
        default:
            break;
    }

    if (!empty($query)) {
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['user_type'] = $userType;

            switch ($userType) {
                case "receiver":
                    header("Location: receiver_dashboard.php");
                    break;
                case "donor":
                    header("Location: donor_dashboard.php");
                    break;
                case "admin":
                    header("Location: admin_dashboard.php");
                    break;
                default:
                    break;
            }
        } else {
            echo "<script> alert('Invalid credentials');  window.location.href = 'index.html';</script> ";
        }
    }
}

$conn->close();
?>
