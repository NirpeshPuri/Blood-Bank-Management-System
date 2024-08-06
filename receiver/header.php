<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank User Dashboard</title>
    <style>
header {
    background-color: tomato;
    color: #fff;
    text-align: center;
    padding: 20px;
    position: relative;
    
}

header h1 {
    margin: 0;
    font-size: 24px;
    display: inline-block;
}

header p {
    margin: 5px 0;
    color: white;
}

.logo {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 120px; 

}

.profile-link {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 16px;
    color: #fff;
    text-decoration: none;
}

nav {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

nav ul li a:hover {
    text-decoration: underline;
}
.d_contact{
    color:white;
}


    </style>
</head>
<body>
    <header>
        <img src="style/logo.jpeg" alt="Blood Bank Logo" class="logo">
        <h1>Receiver Dashboard</h1>
        <a href="edit_receiver_profile.php" class="profile-link">Profile Update</a>
        <a href="receiver_status.php" class="d_contact">Check Status</a>
        
        <p>Blood Bank</p>
        <p>N&N Hospital</p> 
        <p>Contact: +977 980000000</p> 
        
    </header>
    
    
</body>
</html>
