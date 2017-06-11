<?php
session_start();
require_once('inc/top.php'); 
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
$uname=$_SESSION['uname'];
$query="select * from user where username='$uname'";
$run=mysqli_query($conn, $query);
if(mysqli_num_rows($run)){
    $row=mysqli_fetch_row($run);
    $id=$row[0];
    $image=$row[6];
    $fname=$row[2];
    $lname=$row[3];
    $uname=$row[4];
    $email=$row[5];
    $role=$row[8];
    $details=$row[9];
    $date=getdate($row[1]);
    $day=$date['mday'];
    $mon=$date['month'];
    $year=$date['year'];  
}
?>
  </head>
  <body id="profile">
   <div class="wrapper">
       <?php require_once('inc/nav.php'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php require_once('inc/sidebar.php'); ?>
                </div>

                <div class="col-md-9">
                    <h1><i class="fa fa-user" aria-hidden="true"></i> Profile Details</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a> </li> 
                        <li class="active"><i class="fa fa-user" aria-hidden="true"></i> Profile</li>       
                    </ol>
                    <center><img src="img/<?php echo $image;?>" width="200px" class="img-circle img-thumbnail" alt="" id="profile-image"></center><br>
                    <a href="edit-profile.php?edit=<?php echo $id;?>" class="btn btn-primary pull-right">Edit Profile</a><br><hr>
                    <h3>Personal Details</h3><br>
                    <table class="table table-bordered">
                        <tr>
                            <td width="20%"><b>User Id:</b></td>
                            <td width="30%"><?php echo $id;?></td>
                            <td width="20%"><b>Signup Date:</b></td>
                            <td width="30%"><?php echo "$day $mon $year";?></td>
                        </tr>
                        <tr>
                            <td width="20%"><b>First Name:</b></td>
                            <td width="30%"><?php echo ucfirst($fname);?></td>
                            <td width="20%"><b>Last Name:</b></td>
                            <td width="30%"><?php echo ucfirst($lname);?></td>
                        </tr>
                        <tr>
                            <td width="20%"><b>User Name:</b></td>
                            <td width="30%"><?php echo ucfirst($uname);?></td>
                            <td width="20%"><b>Email:</b></td>
                            <td width="30%"><?php echo $email;?></td>
                        </tr>
                        <tr>
                            <td width="20%"><b>Role:</b></td>
                            <td width="30%"><?php echo ucfirst($role);?></td>
                            <td width="20%"></td>
                            <td width="30%"></td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-lg-10 col-sm-12">
                            <p><?php echo $details;?></p>
                        </div>
                    </div><br>
                </div>
            </div>
        </div>
        <?php require_once('inc/footer.php'); ?>
   </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>