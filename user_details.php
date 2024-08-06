<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blood_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$users = [];

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <div class="container">
        <h2>User Details</h2>

        <?php if (!empty($users)): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Blood Type</th>
                    <th>Age</th>
                    <th>Weight</th>
                    <th>User Type</th>


                    <th>Action</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['address']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $user['blood_type']; ?></td>
                        <td><?php echo $user['age']; ?></td>
                        <td><?php echo $user['weight']; ?></td>
                        <td><?php echo $user['user_type']; ?></td>
                        <td>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>

        <a href="admin_dashboard.php">Go to dashboard</a>
    </div>
</body>
</html>
<!--                             <a href="update_user.php?id=<?php echo $user['id']; ?>">Update</a> -->
