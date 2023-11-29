<?php
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/account_details.function.php'); // functions
?>
<title>Account Details</title>

<?php 
  include('includes/movie_head.inc.php'); 
?>

<header>
  <nav>
    <ul>
      <li><a href="weekly_plan.php">Weekly Plan</a></li>
      <li><a href="body_details.php">Body Details</a></li>
      <li><a href="../display_videos/display.html">Display Videos</a></li>
      <li><a href="../../documents/about.html">About Us</a></li>
      <li><a href="logout.php">Log Out</a></li>
    </ul>
  </nav>
</header>

<head>
    <style>
        /* Change the font of all td elements */
        td {
            font-family: Arial, sans-serif;
            font-size: 30px;
        }
        th {
            font-family: Arial, sans-serif;
            font-size: 30px;
        }
        p {
          font-size: 20px;
        }
    </style>
</head>

<h1 style="text-decoration: underline;">Your Account Details</h1>

<br><br>
      
<?php include('includes/menubody.inc.php'); ?>

<?php

  $dbOk = false;

  @ $db = new mysqli('localhost', 'root', '2300', 'team');

  if ($db->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
  } else {
    $dbOk = true;
  }
?>

<table id="userTable">
<?php
if ($dbOk) {
    $username = htmlspecialchars(trim($_SESSION['username']));
    $query = "SELECT * FROM user_details WHERE username = '$username'";
    $newquery1 = "SELECT * FROM user WHERE username = '$username'";
    $result = $db->query($query);
    $newresult1 = $db->query($newquery1);

    if ($result->num_rows > 0) {
        $row = $newresult1->fetch_assoc();
        echo '<tr><th>Username:</th><td>' . htmlspecialchars($row['username']) . '</td></tr>';
        echo '<tr><th>Password:</th><td>' . htmlspecialchars($row['password']) . '</td></tr>';
    } else {
        echo '<tr><td>No user details found.</td></tr>';
    }

    $result->free();
    $db->close();
}
?>
</table>