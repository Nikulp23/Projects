<?php 
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/create_account_function.php'); // functions
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
      height: 825px;
      margin: 6em auto;
      padding: 2em;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>

<h1>Welcome to UNIFIT!</h1>
<img src="../../documents/Unfit_transparent.png" width="200" height="150" style="display: block; margin: 0 auto;"> 

<h5> CREATE ACCOUNT <h5>
      
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

      $username = htmlspecialchars(trim($_POST["username"]));
      $password = htmlspecialchars(trim($_POST["password"]));
      
      $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

      if ($username == '') {
        $errors .= '<li>Username name may not be blank</li>';
        if ($focusId == '') $focusId = '#username';
      }

      // length of the username is less than 4 letters
      if (strlen($username) < 4){
        $errors .= '<li>Username should be atleast 4 characters</li>';
        if ($focusId == '') $focusId = '#username';
      }

      if ($password == '') {
        $errors .= '<li>password may not be blank</li>';
        if ($focusId == '') $focusId = '#password';
      }

      // length of the password is less than 4 letters
      if (strlen($password) < 4){
        $errors .= '<li>Password should be atleast 4 characters</li>';
        if ($focusId == '') $focusId = '#password';
      }

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
          $usernameForDb = trim($_POST["username"]);
          $passwordForDb = trim($_POST["password"]);

          // check if username already exists in the database
          $checkQuery = "SELECT * FROM user WHERE username=?";
          $checkStatement = $db->prepare($checkQuery);
          $checkStatement->bind_param("s", $usernameForDb);
          $checkStatement->execute();
          $checkResult = $checkStatement->get_result();

          if ($checkResult->num_rows == 1) {
            echo '<div class="messages"><h4>Username already exists. Try again.</h4></div>';
          } 
          else {
            // username is unique, proceed with inserting into database
            $insQuery = "INSERT INTO user (`username`,`password`) VALUES (?,?)";
            $statement = $db->prepare($insQuery);
            $statement->bind_param("ss",$usernameForDb,$passwordForDb);
            $statement->execute();

            session_start();
            $_SESSION['username'] = $usernameForDb;

            // give the user some feedback
            echo '<div class="messages"><h4>Success: ' . ' Your Account Has Been Created.</h4>';
            echo 'Username: ' . $usernameForDb . '</div>';

            
            header('Location: details.php');
            exit();
          }

          // close the prepared statement obj
          $checkResult->close();

        }      
      }
    }
  ?>

  <form id="addForm" name="addForm" action="create_account.php" method="post" onsubmit="return validate(this);">
    <fieldset>
      <div class="formGroup">

      <label for="username">Username:</label>
      <input type="text" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $username; } ?>" name="username" id="username"/>

      <br>

      <label for="password">Password:</label>
      <input type="password" size="25" maxlength="25" value="<?php 
      if($havePost && $errors != '') { echo $password; } ?>" name="password" id="password"/>

      <br>
        <input type="submit" value="Create Account" id="save" name="save"/>
      
      </div>
    </fieldset>
  </form>
</table>

<br><br>
<p style="text-align: center;">Already have an account? <a href="login.php">Login in!</a></p>