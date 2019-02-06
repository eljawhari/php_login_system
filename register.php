<?php
//include config
require_once('config.php');

//check if already logged in
if( $user->is_logged_in() ){ header('Location: dashboard.php'); exit; }


// Processing form when request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){

  //start validation
  $errors = array();
  
  $input_email = $_POST["input_email"];
  $input_username = $_POST["input_username"];
  $input_pw = $_POST["input_pw"];
  $input_pw_confirm = $_POST["input_pw_confirm"];
  $input_first_name = $_POST["input_first_name"];
  $input_last_name = $_POST["input_last_name"];

  if (empty($input_email)){
    $errors[] = 'You forgot to enter your email!';
  }elseif (strlen($input_email) > 50){
    $errors[] = 'Email must be max 50 characters lenght!!';  
  }elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'You have not entered a valid email address';
  }elseif ($user->emailExist($input_email)) {
    $errors[] = 'The email '.$input_email.' already exists.';
  }
  else{
    $input_email = htmlspecialchars(trim($input_email));
  }

  if (empty($input_username)){
    $errors[] = 'You forgot to enter your username!';
  }elseif (strlen($input_username) > 50){
    $errors[] = 'Username must be max 50 characters lenght!!';
  }else{
    $input_username = htmlspecialchars(trim($input_username));
  }

  if (empty($input_pw)){
    $errors[] = 'You forgot to enter your password!';
  }elseif (strlen($input_pw) > 100){
    $errors[] = 'Password must be max 50 characters lenght!!';
  }else{
    $input_password = htmlspecialchars(trim($input_pw));
  }
  
  if ($input_pw != $input_pw_confirm){
    $errors[] = 'Passwords do not match.';
  }

  if (empty($input_first_name)){
    $errors[] = 'You forgot to enter your firstname!';
  }elseif (strlen($input_first_name) > 50){
    $errors[] = 'Firstname must be max 50 characters lenght!!';
  }else{
    $input_first_name = htmlspecialchars(trim($input_first_name));
  }

  if (empty($input_last_name)){
    $errors[] = 'You forgot to enter your firstname!';
  }elseif (strlen($input_last_name) > 50){
    $errors[] = 'Lastname must be max 50 characters lenght!!';
  }else{
    $input_last_name = htmlspecialchars(trim($input_last_name));
  }

  //end validation

  if(empty($errors)){
    if($user->register($input_email, $input_pw, $input_username, $input_first_name, $input_last_name)){
      header('Location: dashboard.php');
      exit;
    }else{
      $errors[] = "Please fix all errors";
    }
  }

}

?>
<!DOCTYPE html>
<head>
  <title>CafeT3ch Chalange System Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="style.css" media="all">  
</head>
<body>
  <div class="flex-container">
    <div class="container">
      <?php 
      //showing errors
      if(isset($errors)){
        echo "<ul>";
        foreach($errors as $error){
          echo '<li style="color:red">'.$error.'</li>';
        }
        echo "</ul>";
      }
      ?>
      <form method="post" action="register.php">
        <fieldset>
          <legend><h3>Please Register</h3></legend>
          <p>Email:<input type="text" name="input_email" maxlength="50"/></p>
          <p>Password:<input type="password" name="input_pw" maxlength="100"/></p>
          <p>Password Confirm:<input type="password" name="input_pw_confirm" maxlength="100"/></p>
          <p>Username:<input type="text" name="input_username" maxlength="50"/></p>
          <p>Firstname:<input type="text" name="input_first_name" maxlength="50"/></p>
          <p>Lastname:<input type="text" name="input_last_name" maxlength="50"/></p>
          <p><input type="submit" value="Register" /></p>
         </fieldset>
      </form>
      <br/>
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>