<?php
require_once('config.php');
if(!$user->is_logged_in() ){ header('Location: index.php'); exit;}
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
      welcome back Ms <?php echo $_SESSION['username']; ?><br>
      <a href='logout.php'>logout</a><br>
      <hr/>
      <a href='#'>Profile</a> | <a href='#'>Change Password</a>
      </body>
    </div>
  </div>
</body>
</html>