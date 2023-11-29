<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['rcsid'])) {
        header("Location: ../login/login.html");
        exit();
    }

    include("../php/db_connection.php");

    $rcsid = $_SESSION['rcsid'];
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Post - RPost</title>
<link rel="stylesheet" type="text/css" href="../../css/styles.css" />

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, 
                   initial-scale=1.0">
    <style>
        .box {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* box background */
        .box a {
            display: inline-block;
            background-color: #fff;
            padding: 20px;
            border-radius: 3px;
        }
        .popup-box {
            align-items: center;
            display: flex;
            justify-content: center; 
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(254, 126, 126, 0.7);
            transition: all 0.4s;
            visibility: hidden;
            opacity: 0;
        }
        .content {
            position: absolute;
            background: white;
            width: 1000px;
            padding: 1em 2em;
            border-radius: 4px;
        } 
        .popup-box:target {
            visibility: visible;
            opacity: 1;
        }
        .box-close {
            position: absolute;
            top: 0;
            right: 15px;
            color: #fe0606;
            text-decoration: none;
            font-size: 50px;
        }
    </style>
</head>
 
<body>
    <div class="topnav">
        <img id="cornerLogo" src="../../css/pic.png" alt="RPost logo">
        <a href="../php/logout.php">Logout</a>
        <a href="../chatbot/chatbot.html">Chatbot</a>
        <a href="../details/dashboard.php">Profile</a>
        <a href="../messages/message.php">Messages</a>
        <a href="../tweets/tweet_form.php">Post</a>
        <a href="../main/homepage.php">Home</a>
    </div>

    <div class="container">
        <br><br>
        <h1>Post a tweet!</h1>
        <h3>This tweet after submission will be displayed to all users</h3>

        <form action="./tweets.php" method="POST" class="border">
            <label for="tweet_caption">Caption:</label><br>
            <input type="text" id="tweet_caption" name="tweet_caption" maxlength="255"><br>
            <br>
            <label for="tweet_content">Tweet Content:</label><br>
            <input type="text" id="tweet_content" name="tweet_content" maxlength="280"><br>

            <div class="box">
                <a href="#chat-box"> Talk to AI !</a>
            </div>

            <input type="submit" value="Post">
        </form>

        <a href="./tweets.php">Show my tweets</a>
    </div>

    <!-- adding chatgpt here -->
    <div id="chat-box" class="popup-box">
    <div class="content">
        <h1 style="color: red;">
            <center>Chat with AI</center>
        </h1>
        <div id="chat-messages" style="height: 300px; overflow-y: auto; background: #f1f1f1; padding: 20px; margin-bottom: 10px;">
            <!-- Chat messages will be displayed here -->
        </div>
        <textarea id="chat-input" placeholder="Type your message here..." style="width: 100%;"></textarea>
        <button id="send-message">Send</button>
        <a href="#" class="box-close">×</a>
    </div>
</div>

</body>
<script src="./chatgpt.js"></script>
</html>