<?php
ob_start();
session_start();
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
if(isset($_SESSION['uname']) && $_SESSION['role']=='author'){
    echo "<script>window.top.location='index.php'</script>";
}
require_once('inc/top.php'); ?>
 
<?php
    if(isset($_GET['edit'])){
        $e_id=$_GET['edit'];
        $e_query="select * from user where id='$e_id'";
        $e_run=mysqli_query($conn,$e_query);
        if(mysqli_num_rows($e_run)>0){
            $e_row=mysqli_fetch_row($e_run);
            $e_fname=$e_row[2];
            $e_lname=$e_row[3];
            $e_role=$e_row[8];
            $e_image=$e_row[6];
            $e_details=$e_row[9];
            
        }
        else{
            echo "<script>window.top.location='index.php'</script>";
        }
    }
    else{
        echo "<script>window.top.location='index.php'</script>";
    }
?>
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
                    <h1><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit User</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Users</li>          
                    </ol>
                    <?php
                    
                    if(isset($_POST['submit'])){
                        $fname=mysqli_real_escape_string($conn,$_POST['fname']);
                        $lname=mysqli_real_escape_string($conn,$_POST['lname']);
                        $details=mysqli_real_escape_string($conn,$_POST['details']);
                        
                        $pass=mysqli_real_escape_string($conn,$_POST['pass']);
                        $role=$_POST['role'];
                        $image=$_FILES['image']['name'];
                        $image_tmp=$_FILES['image']['tmp_name'];
                        
                        if(empty($image)){
                            $image=$e_image;
                        }
                        $salt_query="select * from user order by id desc limit 1";
                        $salt_run=mysqli_query($conn, $salt_query);
                        $salt_row=mysqli_fetch_row($salt_run);
                        $salt=$salt_row[10];
                        
                        $insert_pass=crypt($pass, $salt);
                        
                        if(empty($fname) or empty($lname) or empty($image)){
                            $error="All (*) fields are required";
                        }
                       
                        else{
                            $update_query="UPDATE user SET first_name= '$fname', last_name= '$lname', image= '$image', role= '$role', details= '$details' ";
                            if(isset($pass)){
                                $update_query.=", password='$insert_pass'";
                            }
                            
                            $update_query.=" WHERE id= '$e_id'";
                            if(mysqli_query($conn, $update_query)){
                                $msg="User has been updated";
                                header("refresh:0; url=edit-user.php?edit=$e_id");
                                
                                if(!empty($image)){
                                    move_uploaded_file($image_tmp, "img/$image");
                                }
                            }
                            else{
                                $error="User has not been updated";
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
                                   <input id="fname" type="text" value="<?php echo $e_fname;?>"  name="fname" placeholder="First Name" class="form-control">
                               </div>
        
                               <div class="form-group">
                                   <label for="fname">Last name:*</label>
                                   <input id="lname" value="<?php echo $e_lname;?>" type="text" name="lname" placeholder="Last Name" class="form-control">
                               </div>
                        
                           
                               <div class="form-group">
                                   <label for="pass">Password:*</label>
                                   <input id="pass" type="password" name="pass" placeholder="Password" class="form-control">
                               </div>
                         
                           
                               <div class="form-group">
                                   <label for="role">Role:*</label>
                                   <select name="role" id="role" class="form-control">
                                       <option value="author" <?php if($e_role=='author'){echo 'selected';};?>>Author</option>
                                       <option value="admin" <?php if($e_role=='admin'){echo 'selected';};?>>Admin</option>
                                   </select>
                               </div>
                        
                           
                               <div class="form-group">
                                   <label for="image">Profile Picture:*</label>
                                   <input id="image" type="file" name="image">
                                </div>
                                
                                <div class="form-group">
                                   <label for="details">Details:</label>
                                   <textarea class="form-control" name="details" id="details" cols="30" rows="10"><?php echo $e_details ;?></textarea>
                                </div>
                           
                           <input type="submit" name="submit" class="btn btn-primary" value="Edit user">
                           </form>
                       </div>
                       
                       <div class="col-md-4">
                           <?php
                               echo "<img src='img/$e_image' alt='Profile Pic' width='100%''>";
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