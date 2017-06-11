<?php
session_start();
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
if(isset($_SESSION['uname']) && $_SESSION['role']=='author'){
    echo "<script>window.top.location='index.php'</script>";
}
require_once('inc/top.php'); ?>
  </head>
  <body>
   <div class="wrapper">
       <?php require_once('inc/nav.php'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php require_once('inc/sidebar.php'); ?>
                </div>

                <div class="col-md-9">
                    <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-user-plus" aria-hidden="true"></i>Add Users</li>          
                    </ol>
                    <?php
                    
                    if(isset($_POST['submit'])){
                        $fname=mysqli_real_escape_string($conn,$_POST['fname']);
                        $lname=mysqli_real_escape_string($conn,$_POST['lname']);
                        $uname=mysqli_real_escape_string($conn,strtolower($_POST['uname']));
                        $uname_trim=preg_replace('/\s*/','',$uname);
                        $email=mysqli_real_escape_string($conn,strtolower($_POST['email']));
                        $pass=mysqli_real_escape_string($conn,$_POST['pass']);
                        $role=$_POST['role'];
                        $image=$_FILES['image']['name'];
                        $image_tmp=$_FILES['image']['tmp_name'];
                        $date=time();
                        
                        $check_query1="select * from user where email='$email'";
                        $check_run1=mysqli_query($conn,$check_query1);
                        
                        $check_query2="select * from user where username='$uname'";
                        $check_run2=mysqli_query($conn,$check_query2);
                        
                        $salt_query="select * from user order by id desc limit 1";
                        $salt_run=mysqli_query($conn, $salt_query);
                        $salt_row=mysqli_fetch_row($salt_run);
                        $salt=$salt_row[10];
                        
                        $pass=crypt($pass, $salt);
                        
                        if(empty($fname) or empty($lname) or empty($uname) or empty($role) or empty($email) or empty($pass) or empty($image)){
                            $error="All (*) fields are required";
                        }
                        else if($uname!=$uname_trim) {
                            $error="Please do not use spaces in username";
                        }
                        else if(mysqli_num_rows($check_run1)){
                            $error="Email already exist";
                        }
                        else if(mysqli_num_rows($check_run2)){
                            $error="Username already exist";
                        }
                        else{
                            $in_query="INSERT INTO `user` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`) VALUES (NULL, '$date', '$fname', '$lname', '$uname', '$email', '$image', '$pass', '$role')";
                            if(mysqli_query($conn,$in_query)){
                                $msg="User Added";
                                move_uploaded_file($image_tmp, "img/$image");
                                $image_check="select * from user order by id desc limit 1";
                                $check_run=mysqli_query($conn,$image_check);
                                $check_row=mysqli_fetch_row($check_run);
                                $check_image=$check_row[6];
                                
                                $fname="";
                                $lname="";
                                $uname="";
                                $email="";
                            }
                            else{
                                $error= "User not Added";
                            }
                        }
                    }
                    ?>
                   <div class="row">  
                       <div class="col-md-8">
                           <form action="" method="post" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label for="fname">First name:*</label>
                                   <?php
                                   if(isset($error)){
                                       echo "<span class='pull-right' style='color:red;'>$error</span>";
                                   }
                                   else if(isset($msg)){
                                       echo "<span class='pull-right' style='color:green;'>$msg</span>";
                                   }
                                   ?>
                                   <input id="fname" type="text" value="<?php if(isset($fname)){echo $fname;};?>"  name="fname" placeholder="First Name" class="form-control">
                               </div>
        
                               <div class="form-group">
                                   <label for="fname">Last name:*</label>
                                   <input id="lname" value="<?php if(isset($lname)){echo $lname;};?>" type="text" name="lname" placeholder="Last Name" class="form-control">
                               </div>
                          
                           
                               <div class="form-group">
                                   <label for="uname">User name:*</label>
                                   <input id="uname" value="<?php if(isset($uname)){echo $uname;};?>" type="text" name="uname" placeholder="User Name" class="form-control">
                               </div>
                          
                           
                               <div class="form-group">
                                   <label for="email">Email:*</label>
                                   <input id="email" value="<?php if(isset($email)){echo $email;};?>" type="text" name="email" placeholder="Email Address" class="form-control">
                               </div>
                        
                           
                               <div class="form-group">
                                   <label for="pass">Password:*</label>
                                   <input id="pass" type="password" name="pass" placeholder="Password" class="form-control">
                               </div>
                         
                           
                               <div class="form-group">
                                   <label for="role">Role:*</label>
                                   <select name="role" id="role" class="form-control">
                                       <option value="author">Author</option>
                                       <option value="admin">Admin</option>
                                   </select>
                               </div>
                        
                           
                               <div class="form-group">
                                   <label for="image">Profile Picture:*</label>
                                   <input id="image" class="btn btn-default" type="file" name="image">
                                </div>
                           
                           <input type="submit" name="submit" class="btn btn-primary" value="Add user">
                           </form>
                       </div>
                       
                       <div class="col-md-4">
                           <?php
                           if(isset($check_image)){
                               echo "<img src='img/$check_image' alt='Profile Pic' width='100%''>";
                           }
                           ?>
                       </div>
                   </div>
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