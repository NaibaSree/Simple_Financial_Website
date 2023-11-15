<?php
// Database configuration
$host = "localhost";  // Change to your MySQL host
$username = "root";  // Change to your MySQL username
$password = "";  // Change to your MySQL password
$database = "minipro";  // Change to your database name

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $commands = $_POST["commands"];

    // Insert data into the database
    $sql = "INSERT INTO feedback (firstname, lastname, gender, email, mobile, commands) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $gender, $email, $mobile, $commands);
        if (mysqli_stmt_execute($stmt)) { // Save the uploaded file
            echo "Form data submitted successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
