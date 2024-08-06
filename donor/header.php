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

/* Navigation */
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
.profile-link a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;

}


    </style>
</head>
<body>
    <header>
        <img src="style/logo.jpeg" alt="Blood Bank Logo" class="logo">
        <h1>Donor Dashboard</h1>
        
        <p>Blood Bank</p>
        <p>N&N Hospital</p> 
        <p>Contact: +977 980000000</p> 
        
    </header>
    <div class="profile-link">
                <a href="edit_donor_profile.php">Edit Profile</a>
            </div>
            
        <div style="text-align: end;border-right: solid 20px antiquewhite;">
                <a href="donor_status.php">Check status</a>
            </div>
        
    
    
</body>
</html>
