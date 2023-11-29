<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST["first"];
    $last_name = $_POST["last"];
    $email = $_POST["email"];
    $rcsid = $_POST["rcsid"];
    $passcode = $_POST["passcode"];
    $bio = $_POST["bio"];

    // Use provided URL or uploaded file URL; if neither, use a default image URL
    $defaultImageUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN1_yYuKCCC3uu-36xM7XntMDF1cku1S_oNqP2ntw&s'; // Replace with the actual path to your default image
    $pic = $_POST["profilePicUrl"] ?? $defaultImageUrl;

    // Include your database connection script
    include("../php/db_connection.php");

    // Check if an account with the same email or rcsid already exists
    $check_query = "SELECT rcsid FROM account_details WHERE email = '$email' OR rcsid = '$rcsid'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Account already exists
        echo "An account with this email or rcsid already exists. Please log in.";
    } else {
        // If no URL is provided, check for an uploaded file URL or use the default image URL
        if (empty($pic)) {
            $pic = $_POST['profilePicUrl'] ?? $defaultImageUrl;
        }

        // Insert data into the database
        $insert_query = "INSERT INTO account_details (first_name, last_name, email, rcsid, passcode, bio, profile_picture)
                         VALUES ('$first_name', '$last_name', '$email', '$rcsid', '$passcode', '$bio', '$pic')";

        $insert_query_one = "INSERT INTO users (first_name, last_name, rcsid)
                             VALUES ('$first_name', '$last_name', '$rcsid')";

        // Start transaction
        $conn->begin_transaction();

        try {
            if ($conn->query($insert_query) === TRUE && $conn->query($insert_query_one) === TRUE) {
                $conn->commit();
                $_SESSION['rcsid'] = $rcsid;
                // Redirect to the main homepage
                header("Location: ../homepage.php");
                exit();
            } else {
                throw new Exception("Error: " . $conn->error);
            }
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo $e->getMessage();
        }
    }

    // Close the database connection
    $conn->close();
}
?>