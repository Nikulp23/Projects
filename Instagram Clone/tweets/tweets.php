<?php
session_start();

if (!isset($_SESSION['rcsid'])) {
    header("Location: ../login/login.html");
    exit();
}

include("../php/db_connection.php"); 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $rcsid = $_SESSION['rcsid'];
    $tweet_caption = $_POST["tweet_caption"];
    $tweet_content = $_POST["tweet_content"];

    // Insert the tweet into the database
    $insert_query = "INSERT INTO tweets (rcsid, caption, content) 
    VALUES ('$rcsid', '$tweet_caption', '$tweet_content')";
        
    if ($conn->query($insert_query) === TRUE) {
        // Redirect back to the same page to refresh tweets
        header("Location: ./tweets.php");
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

// Retrieve and display tweets for the user
$rcsid = $_SESSION['rcsid'];
$tweets_query = "SELECT * FROM tweets WHERE rcsid = '$rcsid' ORDER BY created_at DESC";
$result = $conn->query($tweets_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tweets</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css" />
    <script src="validate.js"></script>
</head>
<body>

    <div class="topnav">
        <img id="cornerLogo" src="../../css/pic.png" alt="RPost logo">
        <a href="../php/logout.php">Logout</a>
        <a href="../details/dashboard.php">Profile</a>
        <a href="../messages/message.php">Messages</a>
        <a href="../tweets/tweet_form.php">Post</a>
        <a href="../main/homepage.php">Home</a>
    </div>

    <div id="yourTweets">
        <h2>Your Tweets</h2>
        <p>Here all the tweet by our user will be displayed here</p>
        <?php if ($result->num_rows > 0) { $likeArray = array(); $count = 0; ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()) { 
                    $tempString = $row["like_list"];
                    $newTempString = explode(",", $tempString);
                    array_push($likeArray, $newTempString); ?>

                    <li class="tweet border">
                        <div class="tweet-caption"><strong>Caption:</strong> <?php echo $row["caption"]; ?></div>
                        <div class="tweet-content"><strong>Content:</strong> <?php echo $row["content"]; ?></div>
                        <div class="tweet-time"><strong>Created At:</strong> <?php echo $row["created_at"]; ?></div>
                        <div class="tweet-time"><strong>Likes:</strong>
                        <?php if (strlen($likeArray[$count][0]) == 0) { echo "0"; }
                        else { echo count($likeArray[$count]);} ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>You haven't posted any tweets yet.</p>
        <?php } ?>

        <a href="javascript:history.go(-1)">Go Back</a>
    </div>
    <?php $conn->close(); ?>

</body>
</html>