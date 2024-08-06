<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details</title>
    <style>
.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
}

table th {
    background-color: #f2f2f2;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

table th, table td {
    text-align: left;
}

    </style>
</head>
<body>


    <div class="container">
    <a href="admin_dashboard.php" style="float: right;">Go to dashboard</a>
        <h2>Request Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Blood Type</th>
                <th>Blood Quantity</th>
                <th>Request Type</th>
            </tr>
            <?php
            $conn = new mysqli("localhost", "root", "", "blood_bank");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, user, blood_type, blood_quantity, request_type FROM request_detail";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["user"] . "</td>";
                    echo "<td>" . $row["blood_type"] . "</td>";
                    echo "<td>" . $row["blood_quantity"] . "</td>";
                    echo "<td>" . $row["request_type"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No results found</td></tr>";
            }
            

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
