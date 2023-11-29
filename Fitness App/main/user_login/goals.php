
<?php 
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/info_function.php'); // functions
?>
<title>PHP &amp; MySQL - ITWS</title>   

<?php
  include('includes/movie_head.inc.php'); 
?>

<head>
  <style>
    #entering {
      display: flex;
      border-style: solid;
      border-radius: 2em;
      flex-direction: column;
      background-color: white;
      width: 50%;
      height: 950px;
      margin: 6em auto;
      padding: 2em;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }

    td {
      font-family: Arial, sans-serif;
      font-size: 30px;
    }
    th {
        font-family: Arial, sans-serif;
        font-size: 30px;
    }
    p {
      font-size: 19px;
    } 

    .large {
      font-size: 23px;
    }

  </style>
</head>

<img src="../../documents/Unfit_transparent.png" width="270" height="220" style="display: block; margin: 0 auto;"> 

<h5> PICK YOUR GOAL <h5>
      
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

  $havePost = isset($_POST["save"]);

  $errors = '';
    if ($havePost) {

      // Get the output and clean it for output on-screen.
      // First, let's get the output one param at a time.
      // Could also output escape with htmlentities()

        $username = htmlspecialchars(trim($_SESSION['username']));
        $goal = htmlspecialchars(trim($_POST["goal"]));
    
      $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

      if ($errors != '') {
        echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
        echo $errors;
        echo '</ul></div>';
        echo '<script type="text/javascript">';
        echo '  $(document).ready(function() {';
        echo '    $("' . $focusId . '").focus();';
        echo '  });';
        echo '</script>';
      }
      else {
        if ($dbOk) {

          $usernameForDb = (trim($_SESSION["username"]));
          $goalForDb = (trim($_POST["goal"]));

            // username is unique, proceed with inserting into database
            $insQuery = "INSERT INTO user_goals (`username`,`goal`) VALUES (?,?)";
            $statement = $db->prepare($insQuery);
            $statement->bind_param("ss",$usernameForDb,$goalForDb);
            $statement->execute();

            session_start();
            $_SESSION['username'] = $usernameForDb;

            // give the user some feedback
            echo '<div class="messages"><h4>Success: ' . ' Details have been correctly entered.</h4>';
            echo 'Username: ' . $usernameForDb . '</div>';

            header('Location: body_details.php');
            exit();
          }
        }
    }
  ?>

<form id="addForm" name="addForm" action="goals.php" method="post">
  <fieldset>
    <div class="formData">
      <div class="value">
        <input type="radio" name="goal" id="lose-weight" value="Lose Weight" <?php 
        if($havePost && $_POST["goal"]=="Lose Weight") {echo "checked";} ?>><label for="lose-weight" class="large"> Lose Weight</label><br>


        <p>This goal is focused on losing body weight, usually through a combination of diet and exercise. 
          The aim is to reduce overall body fat and improve overall health and fitness.</p>

        <br><br>
      
        <input type="radio" name="goal" id="flexibility" value="Flexibility" <?php 
        if($havePost && $_POST["goal"]=="Flexibility") {echo "checked";} ?>><label for="flexibility" class="large"> Flexibility</label><br>

        <p>Flexibility: This goal is focused on improving the range of motion and elasticity of the muscles and joints. 
          The aim is to prevent injury, improve posture, and enhance athletic performance.</p>
        
        <br>

        <input type="radio" name="goal" id="get-toned" value="Get Toned" <?php 
        if($havePost && $_POST["goal"]=="Get Toned") {echo "checked";} ?>><label for="get-toned" class="large"> Get Toned</label><br>

        <p>Get Toned: This goal is focused on building lean muscle mass and reducing body fat to create a toned appearance. 
          The aim is to increase strength and improve body composition.</p>

      <br>

      <div style="text-align: center;">
        <input type="submit" value="DONE" id="save" name="save"/>
      </div>

    </div>
  </fieldset>
</form>


<br><br>
<p style="text-align: center;">UNIFIT: Uniting With Your Best Fit! </p>