<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$my_email = $_POST["r_email"];
$my_name = $_POST["r_name"];
$my_password = $_POST["r_password"];


$sql = "SELECT * FROM sys_user WHERE email='$my_email'";

if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    if ($row) {
        echo "<h1>Email Already Exists, Please Login!</h1><br>";
        echo '<a href="login.html">Back</a>';

    } else {
        $sql = "INSERT INTO sys_user (email , user_name , user_password,user_role) VALUES ('$my_email','$my_name','$my_password','CUSTOMER')";

        if ($conn->query($sql) === TRUE) {
            //get user id
            $sql = "SELECT * FROM sys_user WHERE email='$my_email' and user_password='$my_password' ";

            if ($result = $conn->query($sql)) {
                $row = $result->fetch_assoc();
                if ($row) {
                    session_start();
                    $_SESSION['user_id'] = $row["user_id"];
                    header('location:search.php');
                }
            }

        } else {
            echo "<h1>Failed to Register!</h1><br>";
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "<h1>Failed to Register!</h1><br>";
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();