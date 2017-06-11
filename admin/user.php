<?php 
session_start();
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
if(isset($_SESSION['uname']) && $_SESSION['role']=='author'){
    echo "<script>window.top.location='index.php'</script>";
}
require_once('inc/top.php'); ?>
 
<?php
    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $id){
            
            $bulk_option = $_POST['bulk-options'];
               
            if($bulk_option=='delete'){
                $bulk_del_query="DELETE FROM `user` WHERE `user`.`id` = $id";
                mysqli_query($conn, $bulk_del_query);
            }
            else if($bulk_option=='author'){
                $bulk_author_query="UPDATE `user` SET `role` = 'author' WHERE `user`.`id` = $id";
                mysqli_query($conn, $bulk_author_query);
            }
            else if($bulk_option=='admin'){
                $bulk_admin_query="UPDATE `user` SET `role` = 'admin' WHERE `user`.`id` = $id";
                mysqli_query($conn, $bulk_admin_query);
            }
        }
    }
?>
  </head>
  <body>
   <div class="wrapper">
       <?php require_once('inc/nav.php'); 
       
            if(isset($_GET['del'])){
                $del_id=$_GET['del'];
                $del_check="select * from user where id='$del_id'";
                $del_check_run=mysqli_query($conn, $del_check);
                if(mysqli_num_rows($del_check_run)>0){
                    $del_query="DELETE FROM user WHERE id = '$del_id'";
                    if(isset($_SESSION['uname']) && $_SESSION['role']=='admin'){
                        if(mysqli_query($conn, $del_query)){
                            $msg="User has been deleted successfully";
                        }
                        else{
                            $error="User not deleted";
                        }
                    }
                }
                else{
                    echo "<script>window.top.location='index.php'</script>";
                }
            }
       ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php require_once('inc/sidebar.php'); ?>
                </div>

                <div class="col-md-9">
                    <h1><i class="fa fa-users" aria-hidden="true"></i> Users</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Users</li>          
                    </ol>
                    
                    <?php 
                    
                    $query="select * from user order by id desc";
                    $run=mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($run)){
                        
                    ?>
                    <form action="" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-lg-8">
                            <div class="row">
                                <div class="col-xs-8 col-lg-4">
                                   <div class="form-group">
                                       <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="author">Change to author</option>
                                            <option value="admin">Change to admin</option>
                                        </select>
                                   </div>
                                    
                                </div>
                                <div class="col-xs-4 col-lg-8">
                                    <input type="submit" value="Apply" class="btn btn-success">
                                    <a href="add-user.php" class="btn btn-primary">Add new</a>
                                </div>
                            </div>                                           
                        </div>
                    </div><br><br>
                    <?php
                        if(isset($error))
                            echo "<span style='color:red;'>$error</span>";
                        else if(isset($msg))
                            echo "<span style='color:green;'>$msg</span>";
                    ?>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><input id="selectallboxes" onClick="selectall(this)" type="checkbox"></th>
                                <th>Sr #</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Del</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                            while($row=mysqli_fetch_row($run)){
                                $id=$row[0];
                                $date=getdate($row[1]);
                                $day=$date['mday'];
                                $month=substr($date['month'],0,3);
                                $year=$date['year'];
                                $fname=ucfirst($row[2]);
                                $lname=ucfirst($row[3]);
                                $uname=$row[4];
                                $email=$row[5];
                                $image=$row[6];
                                $pass=$row[7];
                                $role=$row[8];
                            ?>    
                                <tr> 
                                    <td><input id="checkboxes" class="chk" name="checkboxes[]" value="<?php echo $id;?>" type="checkbox"></td>
                                    <td><?php echo $id;?></td>
                                    <td><?php echo "$day $month $year";?></td>
                                    <td><?php echo "$fname $lname";?></td>
                                    <td><?php echo $uname;?></td>
                                    <td><?php echo $email;?></td>
                                    <td><img src="img/<?php echo $image;?>" width="30px" alt=""></td>
                                    <td>**********</td>
                                    <td><?php echo ucfirst($role);?></td>
                                    <td><a href="edit-user.php?edit=<?php echo $id;?>"><i class="fa fa-pencil"></i></a></td>
                                    <td><a href="user.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
                                </tr> 
                            <?php } ; ?>                        
                        </tbody>
                    </table>
                    </form>
                    <?php } ; ?>
                </div>           
            </div>
        </div>

        <?php require_once('inc/footer.php'); ?>
        </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/code.js"></script>

  </body>
</html>