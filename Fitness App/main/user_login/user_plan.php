<?php
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/body_details.function.php'); // functions
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php 
  include('includes/movie_head.inc.php'); 
?>

<h1>Welcome to UNIFIT !</h1>
      
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

<h5>BMI : stands for Body Mass Index. It is a measure of body fat based on height and weight.</h5>
<h5>BMR : stands for Basal Metabolic Rate, which is the number of calories that a person's body burns 
    at rest in order to maintain basic functions such as breathing, circulation, and temperature 
    regulation. </h5>
<h3>Body Details:</h3>
<table id="userTable">
<?php
if ($dbOk) {
    $username = htmlspecialchars(trim($_SESSION['username']));
    $weeklyplanq = "SELECT * FROM weekly_plan WHERE username = '$username'";
    $weeklyplanr = $db->query($weeklyplanq);
    if ($weeklyplanr->num_rows > 0) {
        $row = $weeklyplanr->fetch_assoc();
        echo '<tr><th>Day: </th><td>' . htmlspecialchars($row['day']) . '</td></tr>';
        echo '<tr><th>Exercise: </th><td>' . htmlspecialchars($row['exercise']) . '</td></tr>';
        echo '<tr><th>Duration: </th><td>' . htmlspecialchars($row['duration_reps']) . '</td></tr>';
    } else {
        echo '<tr><td>No user details found.</td></tr>';
    }
    $result->free();
    $db->close();
}
?>
</table>

<?php include('includes/foot.inc.php'); 
  // footer info and closing tags
?>