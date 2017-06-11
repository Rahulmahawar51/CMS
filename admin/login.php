<!DOCTYPE html>
<?php 
session_start();
require_once("../inc/db.php"); 
    if(isset($_POST['submit'])){
        $uname=mysqli_real_escape_string($conn,strtolower($_POST['uname']));
        $pass=mysqli_real_escape_string($conn,$_POST['pass']);
        
        $check_uname_query="select * from user where username='$uname'";
        $check_uname_run=mysqli_query($conn, $check_uname_query);
        if(mysqli_num_rows($check_uname_run)){
            $check_uname_row=mysqli_fetch_array($check_uname_run);
            $db_uname=$check_uname_row[4];
            $db_pass=$check_uname_row[7];
            $db_role=$check_uname_row[8];
            $db_author_image=$check_uname_row[6];
            
            $pass=crypt($pass,$db_pass);
            if($db_pass==$pass && $db_uname==$uname){
                $_SESSION["uname"]=$db_uname;
                $_SESSION["role"]=$db_role;
                $_SESSION["author_image"]=$db_author_image;
                echo "<script>window.top.location='index.php'</script>";
                
            }
            else{
                $error="Username or Password is wrong";
            }
        }
        else{
            $error="Username or Password is wrong";
        }
    }

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/tapad-square.png">

    <title>Login Page | Trendy</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <link rel="stylesheet" href="css/login.css">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">LOGIN</h2>
        <label for="username" class="sr-only">User Name</label>
        <input type="text" id="uname" name="uname" class="form-control" placeholder="User Name" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <?php
              
              if(isset($error))
                echo $error;
              ?>
          </label>
        </div>
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Sign In">
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
