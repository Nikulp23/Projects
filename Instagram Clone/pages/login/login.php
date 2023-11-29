<?php
// Start a session
session_start();

include("../php/db_connection.php"); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $rcsid = $_POST["rcsid"];
    $passcode = $_POST["passcode"];

    // Query the database to authenticate the user
    $query = "SELECT * FROM account_details WHERE rcsid = '$rcsid' AND passcode = '$passcode'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Store user information in the session
        $_SESSION['rcsid'] = $row['rcsid'];
        
        // Redirect to the user's dashboard or another page
        header("Location: ../homepage.php");
        exit();
    } else {
        // display an error message
        echo "Invalid email or RCSID. Please check your input.";
    }

    $conn->close();
}
?>