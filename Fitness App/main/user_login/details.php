
<?php 
  session_start();
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/create_account_function.php'); // functions
?>
<title>Details</title>   

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
      height: 800px;
      margin: 6em auto;
      padding: 2em;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>

<img src="../../documents/Unfit_transparent.png" width="200" height="150" style="display: block; margin: 0 auto;"> 

<h5> ENTER YOUR DETAILS <h5>
      
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
        $height = htmlspecialchars(trim($_POST["height"]));
        $weight = htmlspecialchars(trim($_POST["weight"]));
        $age = htmlspecialchars(trim($_POST["age"]));
        $gender = htmlspecialchars(trim($_POST["gender"]));

    
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
          $heightForDb = (trim($_POST["height"]));
          $weightForDb = (trim($_POST["weight"]));
          $ageForDb = (trim($_POST["age"]));
          $genderForDb = (trim($_POST["gender"]));

            // username is unique, proceed with inserting into database
            $insQuery = "INSERT INTO user_details (`username`,`height`,`weight`,`age`,`gender`) VALUES (?,?,?,?,?)";
            $statement = $db->prepare($insQuery);
            $statement->bind_param("sidis",$usernameForDb,$heightForDb,$weightForDb,$ageForDb,$genderForDb);
            $statement->execute();


            session_start();
            $_SESSION['username'] = $usernameForDb;

            // give the user some feedback
            echo '<div class="messages"><h4>Success: ' . ' Details have been correctly entered.</h4>';
            echo 'Username: ' . $usernameForDb . '</div>';


            header('Location: goals.php');
            exit();
          }
        }
    }
  ?>

  <form id="addForm" name="addForm" action="details.php" method="post" onsubmit="return validate(this);">
    <fieldset>
      <div class="formGroup">

      <label for="height">Height (cm):</label>
      <input type="text" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $username; } ?>" name="height" id="height"/>

    <label for="Weight">Weight (kg):</label>
      <input type="text" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $username; } ?>" name="weight" id="weight"/>

      <label for="Age">Age:</label>
      <input type="text" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $username; } ?>" name="age" id="age"/>

      <label for="gender">Gender:</label>
      <input type="text" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $username; } ?>" name="gender" id="gender"/>

      <br>
        <input type="submit" value="Continue to GOALS" id="save" name="save"/>
      
      </div>
    </fieldset>
  </form>
</table>

<br><br>
<p style="text-align: center;">UNIFIT: Uniting With Your Best Fit! </p>