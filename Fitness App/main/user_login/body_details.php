<?php
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/body_details.function.php'); // functions
?>
<title>Body Details</title>

<?php 
  include('includes/movie_head.inc.php');
?>

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
        #entering {
        display: flex;
        border-style: solid;
        border-radius: 2em;
        flex-direction: column;
        background-color: white;
        width: 50%;
        height: 900px;
        margin: 6em auto;
        padding: 2em;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      }
    </style>
</head>

<header>
  <nav>
    <ul>
      <li><a href="weekly_plan.php">Weekly Plan</a></li>
      <li><a href="account_details.php">Account Details</a></li>
      <li><a href="../display_videos/display.html">Display Videos</a></li>
      <li><a href="../../documents/about.html">About Us</a></li>
      <li><a href="logout.php">Log Out</a></li>
    </ul>
  </nav>
</header>

<h1>BODY DETAILS</h1>
      
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

<p><a href="https://www.cdc.gov/healthyweight/assessing/bmi/index.html">BMI:</a> stands for Body Mass Index. 
It is a measure of body fat based on height and weight.</p>

<p><p><a href="https://www.betterhealth.vic.gov.au/health/conditionsandtreatments/metabolism">BMR:</a> stands for Basal Metabolic Rate, which is the number of calories that a person's body burns 
    at rest in order to maintain basic functions such as breathing, circulation, and temperature 
    regulation. </p>

<p><p><a href = "https://inbodyusa.com/blogs/inbodyblog/lean-body-mass-and-muscle-mass-whats-the-difference/">LBM:</a> stands for Lean Body Mass. This is the weight of your body without the fat.
 It is calculated by subtracting the body fat weight from the total body weight.</p>

 <p><p><a href = "https://inbodyusa.com/blogs/inbodyblog/40668865-your-body-and-you-a-guide-to-body-water/">TBW:</a> stands for Total Body Water. This is the total amount of water in your body. It can be calculated using your age, height, and weight.</p>

<br><br>

<table id="userTable">
<?php

if ($dbOk) {
    $username = htmlspecialchars(trim($_SESSION['username']));
    $query = "SELECT * FROM user_details WHERE username = '$username'";
    $newquery1 = "SELECT * FROM user WHERE username = '$username'";
    $result = $db->query($query);
    $newresult1 = $db->query($newquery1);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        echo '<tr><th>Height:</th><td>' . htmlspecialchars($row['height']) . ' cm</td></tr>';
        echo '<tr><th>Weight:</th><td>' . htmlspecialchars($row['weight']) . ' kg</td></tr>';
        echo '<tr><th>Age:</th><td>' . htmlspecialchars($row['age']) . '</td></tr>';
        echo '<tr><th>Gender:</th><td>' . htmlspecialchars($row['gender']) . '</td></tr>';

        $bmi = calculate_bmi($row['height'], $row['weight']);
        $bmr = calculate_bmr($row['gender'], $row['weight'], $row['height'], $row['age']);
        $body_fat_percentage = calculate_body_fat_percentage($row['gender'], $row['weight'], $row['height'], $row['age']);
        $lbm = calculate_lbm($row['gender'],$row['weight'],$body_fat_percentage);
        $tbm = calculate_tbw($row['gender'],$row['weight'],$row['height'],$row['age']);

        echo '<tr><th>BMI (Body Mass Index):</th><td>' . $bmi . '</td></tr>';
        echo '<tr><th>BMR (Basal Metabolic Rate):</th><td>' . $bmr . '</td></tr>';
        echo '<tr><th>Body Fat Percentage:</th><td>' . $body_fat_percentage . '%</td></tr>';
        echo '<tr><th>Lean Body Mass:</th><td>' . $lbm . ' kg</td></tr>';
        echo '<tr><th>Total Body Water:</th><td>' . $tbm . ' litres</td></tr>';

    } else {
        echo '<tr><td>No user details found.</td></tr>';
    }

    $result->free();
    $db->close();
}
?>
</table>

<br><br>
<p style="text-align: center;">UNIFIT: Uniting With Your Best Fit! </p>