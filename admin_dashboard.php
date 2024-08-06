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

$sql = "SELECT * FROM make_request where status='pending'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$requests = [];

if ($result->num_rows > 0) {
    $requests = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<?php include_once('admin/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/admin.css">
    <style>
        .small-img {
            width: 150px;
            height: auto;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 800px;
        }

        .modal-content img {
            width: 100%;
            height: auto;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" style="float: right;">Logout</a>
        <h2>Welcome, <?php echo $admin; ?></h2>

        <div class="menu">
            <table id="table1">
                <tr>
                    <td><a href="admin_dashboard.php">Receiver Requests</a></td>
                    <td><a href="donor_requests.php">Donor Requests</a></td>
                    <td><a href="user_details.php">User Details</a></td>
                    <td><a href="stock_blood.php">Blood Stock</a></td>
                    <td><a href="request_detail.php">Request Details</a></td>

                </tr>
            </table>
        </div>

        <h3>Blood Donation Requests</h3>
        
        <?php if (!empty($requests)): ?>
            <table id="table2">
                <tr>
                    <th>User</th>
                    <th>Blood Type</th>
                    <th>Blood Quantity</th>
                    <th>Receiver Request Form or Driving Lisence</th>

                    <th>Action</th>
                </tr>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?php echo $request['user']; ?></td>
                        <td><?php echo $request['blood_type']; ?></td>
                        <td><?php echo $request['blood_quantity']; ?> unit</td>
                        <td><img src="<?php echo $request['rec_card_path']; ?>" alt="Receiver Card or Driving License" class="small-img" onclick="openModal('<?php echo $request['rec_card_path']; ?>')"></td>

                        <td>
                            <a href="accept_request.php?id=<?php echo $request['req_id']; ?>">Accept</a>
                            <a href="reject_request.php?id=<?php echo $request['req_id']; ?>">Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No blood donation requests at the moment.</p>
        <?php endif; ?>

        
        <br><br><br><br>
    </div>
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <script>
        // Function to open modal and display larger image
        function openModal(src) {
            var modal = document.getElementById('myModal');
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = src;
        }

        // Function to close modal
        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        }
    </script>
</body>
</html>
<?php include_once('admin/footer.php'); ?>