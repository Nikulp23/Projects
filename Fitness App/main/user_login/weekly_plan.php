<?php
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/weekly_plan.function.php'); // functions
?>
<title>Weekly Plan</title>
<?php 
  include('includes/movie_head.inc.php'); 
?>
 
<?php include('includes/menubody.inc.php'); ?>

<header>
  <nav>
    <ul>
      <li><a href="body_details.php">Body Details</a></li>
      <li><a href="account_details.php">Account Details</a></li>
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

<h1 style="text-decoration: underline;">Your Weekly Plan</h1>
<br><br>   

<table id="userTable">
<form id="addForm" name="addForm" action="weekly_plan.php" method="post">
  <fieldset>

    <div class="formData">
      <input type="submit" value="Generate Weekly Plan!" id="Generate" name="Generate"/>
      <br><br>
    </div>
    
  </fieldset>
</form>
 
<?php
$dbOk = false;
@ $db = new mysqli('localhost', 'root', '2300', 'team');
if ($db->connect_error) {
  echo '<div class="messages">Could not connect to the database. Error: ';
  echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
  $dbOk = true;
}
 
$havePost = isset($_POST["Generate"]);
 
$errors = '';
  if ($havePost) {
        if ($dbOk) {
          $username = htmlspecialchars(trim($_SESSION['username']));
          $insQuery = "insert into weekly_plan(username, type, day, exercise, duration_reps) select '$username', type, day_of_week, workout_name, concat(sets,' x ',reps) from fitness_plan_workouts where type = (select goal from user_goals where username='$username') and not exists (select 1 from weekly_plan where username='$username')";
          $statement = $db->prepare($insQuery);
          $statement->execute();
          echo '<div class="messages"><h4>Success: ' . ' Your weekly plan has been generated.</h4></div>';
          header('Location: weekly_plan.php');
          exit();
        }
      }
 
if ($dbOk) {
    $username = htmlspecialchars(trim($_SESSION['username']));
    $query = "SELECT * FROM user_details WHERE username = '$username'";
    $newquery1 = "SELECT * FROM user WHERE username = '$username'";
   
    $result = $db->query($query);
    $newresult1 = $db->query($newquery1);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<tr><td>No user details found.</td></tr>';
    }
    
    $newquery = "SELECT * FROM user_goals WHERE username = '$username'";
    $newresult = $db->query($newquery);
    if ($newresult->num_rows > 0) {
        $row = $newresult->fetch_assoc();
        echo '<tr><th>Goal:</th><td>' . htmlspecialchars($row['goal']) . '</td></tr>';
    } else {
        echo '<tr><td>No user details found.</td></tr>';
    }
 
    $weeklyplanq = "SELECT * FROM weekly_plan WHERE username = '$username'";
    $weeklyplanr = $db->query($weeklyplanq);
    $numRecords = $weeklyplanr->num_rows;
    if ($numRecords > 0) {
      echo '<table>';
      echo '<tr><th>Day</th><th>Exercise</th><th>Duration/Reps</th></tr>';
      for ($i = 0; $i < $numRecords; $i++) {
        $row = $weeklyplanr->fetch_assoc();
        echo '<tr>';
        echo '<td>' . $row['day'] . '</td>';
        echo '<td>' . $row['exercise'] . '</td>';
        echo '<td>' . $row['duration_reps'] . '</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
        echo '<tr><td>No user weekly plan found.</td></tr>';
    }
    $result->free();
    $db->close();
  }
?>
</table>

<br><br>
<p style="text-align: center;">UNIFIT: Uniting With Your Best Fit! </p>