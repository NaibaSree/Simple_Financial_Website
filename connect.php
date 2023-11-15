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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Loan Candidate Form Submission
    if (isset($_POST["Name"]) && isset($_POST["NativePlace"]) && isset($_POST["MobileNumber"]) && isset($_POST["EmailID"]) && isset($_POST["Address"])) {
        $Name = $_POST["Name"];
        $NativePlace = $_POST["NativePlace"];
        $MobileNumber = $_POST["MobileNumber"];
        $EmailID = $_POST["EmailID"];
        $Address = $_POST["Address"];
        $RegisterDocument = $_FILES["RegisterDocument"]["name"];
        $MODHypothecation = $_FILES["MODHypothecation"]["name"];
        $CheckLeaf = $_FILES["CheckLeaf"]["name"];
        $Photo = $_FILES["Photo"]["name"];
        $AadharCard = $_FILES["AadharCard"]["name"];
        $PanCard = $_FILES["PanCard"]["name"];
        $BankPassbookXerox = $_FILES["BankPassbookXerox"]["name"];
        $Security = $_FILES["Security"]["name"];
        $PronoteType = isset($_POST["PronoteType"]) ? $_POST["PronoteType"] : null;

        // Handle file uploads and move the files to a folder
        $upload_dir = "uploads/";

        move_uploaded_file($_FILES["RegisterDocument"]["tmp_name"], $upload_dir . $RegisterDocument);
        move_uploaded_file($_FILES["MODHypothecation"]["tmp_name"], $upload_dir . $MODHypothecation);
        move_uploaded_file($_FILES["CheckLeaf"]["tmp_name"], $upload_dir . $CheckLeaf);
        move_uploaded_file($_FILES["Photo"]["tmp_name"], $upload_dir . $Photo);
        move_uploaded_file($_FILES["AadharCard"]["tmp_name"], $upload_dir . $AadharCard);
        move_uploaded_file($_FILES["PanCard"]["tmp_name"], $upload_dir . $PanCard);
        move_uploaded_file($_FILES["BankPassbookXerox"]["tmp_name"], $upload_dir . $BankPassbookXerox);
        move_uploaded_file($_FILES["Security"]["tmp_name"], $upload_dir . $Security);

        // Insert data into the loan_candidates table
        $sql = "INSERT INTO loan_candidates (Name, NativePlace, MobileNumber, EmailID, Address, 
                RegisterDocument, MODHypothecation, CheckLeaf, Photo, AadharCard, PanCard, 
                BankPassbookXerox, Security, PronoteType) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
           mysqli_stmt_bind_param($stmt, "ssissssssssssi", $Name, $NativePlace, $MobileNumber, $EmailID, $Address, 
             $RegisterDocument, $MODHypothecation, $CheckLeaf, $Photo, $AadharCard, $PanCard, 
             $BankPassbookXerox, $Security, $PronoteType);

            if (mysqli_stmt_execute($stmt)) {
                echo "Loan Candidate Form submitted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
