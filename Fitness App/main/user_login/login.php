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
      height: 800px;
      margin: 6em auto;
      padding: 2em;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>


<h1>Welcome to UNIFIT!</h1>
<img src="../../documents/Unfit_transparent.png" width="200" height="150" style="display: block; margin: 0 auto;"> 

<h5> LOGIN <h5>

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
  $username = htmlspecialchars(trim($_POST["username"]));
  $password = htmlspecialchars(trim($_POST["password"]));

  $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

  if ($username == '') {
    $errors .= '<li>username name may not be blank</li>';
    if ($focusId == '') $focusId = '#username';
  }
  if ($password == '') {
    $errors .= '<li>password may not be blank</li>';
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
  } else {
    if ($dbOk) {
      // Let's trim the input for inserting into mysql
      // Note that aside from trimming, we'll do no further escaping because we
      // use prepared statements to put these values in the database.
      $usernameForDb = trim($_POST["username"]);
      $passwordForDb = trim($_POST["password"]);

      // Query the database for a matching record
      $query = "SELECT * FROM user WHERE username = ? AND password = ?";
      $statement = $db->prepare($query);
      $statement->bind_param("ss", $usernameForDb, $passwordForDb);
      $statement->execute();
      $result = $statement->get_result();

      if ($result->num_rows === 1) {

        session_start();
        $_SESSION['username'] = $usernameForDb;

        // Success! they entered the right data
        header("Location: body_details.php");
        exit();


      } else {
        // No matching record found
        echo '<div class="messages"><h4>Invalid username or password.</h4></div>';
      }

      // close the prepared statement obj
      $statement->close();
    }      
  }
}
?>

<form id="addForm" name="addForm" action="login.php" method="post" onsubmit="return validate(this);">
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
      <input type="submit" value="Login" id="save" name="save"/>
    </div>
  </fieldset>
</form>

<br><br>
<p style="text-align: center;">Don't have an account? <a href="create_account.php">Sign up!</a></p>