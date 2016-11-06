<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
  </head>
  <body background="./images/love-sand.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="#">Vicini</a></span> Love
    </header>
    <div id='container'>
      <div id="hide" class="btn-container">
        <button type="button" class="btn" id="login" name="login">login</button>
        <button type="button" class="btn" id="signup" name="signup">signup</button>
     </div>
      <div id="show" class='signup'>
          <h1 id="form-title">login</h1>
         <form name="user_login" onsubmit="return formValidate()" action="" method="post">
           <input type='text' name="email" placeholder='Email Address:'/>
           <input type='password' required name="passwd" placeholder='Password:'/>
           <input type='submit' name="submit" value="login" placeholder='login'/>
         </form>
         <div id="bottom-links">
          <a href="reset.php"><span>forgot your password?</span></a>
          <a href="register.php"><span>Don't have an account? Register</span></a>
         </div>
    </div>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/login.js">
    </script>
  </body>
</html>

<?php
session_start();
require_once "db_object.php";

if (!empty($_SESSION['username'])) {
	header("Location: index.php");
}
if(isset($_POST['submit']))
{
  try
	{
    $email = htmlspecialchars(trim($_POST['email']));
    $passw = htmlspecialchars(trim($_POST['passwd']));
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
      $start->__setReport("valid email");
      print $start->__getReport();
      header("refresh : 3; login.php");
      return;
    }
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT active, username, password, email FROM users
                           WHERE email = :email");
		$sql->bindParam(":email", $email);
    $sql->execute();
		$res = $sql->fetch();
		if ($sql->rowCount() > 0 && $res['active'] == 0)
		{
			header("Location: notverified.php");
		}
    if (!password_verify($passw, $res['password']))
    {
      $start->__setReport("incorrect password");
      print $start->__getReport();
      header("refresh : 3; login.php");
      return;
    }
    if($sql->rowCount() > 0 && $res['active'] == 1)
    {
      $uname = $res['username'];
			$_SESSION['username'] = $uname;
			header("Location: index.php");
		}
		else {
			$start->__setReport("<strong>unknown user</strong>". PHP_EOL);
      print $start->__getReport();
		}
	}
	catch (PDOException $err) {
		$start->__setReport($sql ."". $err->getMessage());
    print $start->__getReport();
	}
}
$conn = null;

?>
