<?php
//include config
require_once('config.php');

//check if already logged in
if( $user->is_logged_in() ){ header('Location: dashboard.php'); exit; }


//allow request method POST:
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){

  $errors = array();
  $email = $_POST["input_email"];
  $password = $_POST["input_pw"];

  //checking email address:
  if (empty($email)){
    $errors[] = 'You forgot to enter your email!';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'You have not entered a valid email address';
  }else{
    $login_email = htmlspecialchars(trim($email));
  }

  //checking password:
  if (empty($password)){
    $errors[] = 'You forgot to enter your password!';
  }else{
    $login_password = htmlspecialchars(trim($password));
  }

  if(empty($errors)){
    if($user->login($login_email,$login_password)){
      header('Location: dashboard.php');
      exit;
    }else{
      $errors[] = "Invalid credentials! If you are not registered please register bellow!";
    }
  }
}

unset($user);

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
      <form method="post" action="login.php">
        <fieldset>
          <legend><h3>Please login</h3></legend>
          <p>Email:<input type="text" name="input_email" maxlength="50"/></p>
          <p>Password:<input type="password" name="input_pw" maxlength="100"/></p>
          <p><input type="submit" value="Login"/></p>
        </fieldset>
      </form>
      <br/>
      <a href="register.php">Login</a>
      Don't have an account yet?<a href="register.php"> Register</a>
    </div>
  </div>
</body>
</html>