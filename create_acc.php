<?php
session_start();
require_once "db_object.php";

if (isset($_POST['submit']))
{
  $fname = htmlspecialchars($_POST['fname']);
  $lname = htmlspecialchars($_POST['lname']);
  $email = htmlspecialchars($_POST['email']);
  $uname = htmlspecialchars($_POST['uname']);
  $passw = htmlspecialchars($_POST['passwd']);
  $cpass = htmlspecialchars($_POST['cpassw']);

  if ($passw != $cpass) {
    $start->__setReport("password dont match". PHP_EOL);
    print $start->__getReport();
    header("refresh : 3; register.php");
  }
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
  {
    $start->__setReport("email is not valid");
    print $start->__getReport();
    header("refresh : 3; register.php");
  }
  if (strlen($passw) < 6)
  {
    $start->__setReport("password must be a minimum of 6 characters");
    print $start->__getReport();
    header("refresh : 3; register.php");
  }
  else
  {
    try {
      $_SESSION['email'] = $email;
      $conn = $start->server_connect();
      $sql = $conn->prepare("SELECT * FROM users WHERE email = :email OR username = :uname");
      $sql->bindParam(":email", $email);
      $sql->bindParam(":uname", $uname);
      $sql->execute();
      if($sql->rowCount() > 0) {
        $start->__setReport("<div id=error>ERROR: either an email or username already exists in database</div>");
        print $start->__getReport();
        header("refresh : 3; register.php");
      }
      else {
        $err_val = "<br><strong>this email doesn't exist in the database</strong><br>";
      }
      $sql = $conn->prepare("INSERT INTO users(`firstname`, `lastname`, `username`, `email`, `password`)
      VALUES('".$fname."','".$lname."', '".$uname."', '".$email."', '".$passw."')");
      if ($sql->execute())
        $start->__setReport("insertion success");
        print $start->__getReport();
        header("Location: verify.php");
    }
    catch(PDOException $error) {
      $start->__setReport($error->getMessage());
      print $start->__getReport();
    }
    $conn = null;
  }
}
else {
  header('Location: register.php');
}

?>
