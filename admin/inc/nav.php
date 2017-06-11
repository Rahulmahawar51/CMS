<?php
    $session_usrname1=$_SESSION['uname'];
    $session_role1=$_SESSION['role'];
?>

<nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Trendy</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


              <ul class="nav navbar-nav navbar-right">
                <li><a href="">Welcome <i class="fa fa-user" aria-hidden="true"></i> <?php echo $session_usrname1;?></a></li>
                <li><a href="add-post.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Post</a></li>
                <?php
                 if(isset($_SESSION['role']) and $session_role1=='admin'){
                 ?>
                <li><a href="add-user.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</a></li>
                <?php }?>
                <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                <li><a href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </nav>