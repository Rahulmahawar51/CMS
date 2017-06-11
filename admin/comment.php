<?php 
session_start();
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
if(isset($_SESSION['uname']) && $_SESSION['role']=='author'){
    echo "<script>window.top.location='index.php'</script>";
}
require_once('inc/top.php'); 
$session_uname=$_SESSION['uname'];
?>

<?php
    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $id){
            
            $bulk_option = $_POST['bulk-options'];
               
            if($bulk_option=='delete'){
                $bulk_del_query="DELETE FROM `comment` WHERE `comment`.`id` = $id";
                mysqli_query($conn, $bulk_del_query);
            }
            else if($bulk_option=='approve'){
                $bulk_author_query="UPDATE `comment` SET `status` = 'publish' WHERE `comment`.`id` = $id";
                mysqli_query($conn, $bulk_author_query);
            }
            else if($bulk_option=='unapprove'){
                $bulk_admin_query="UPDATE `comment` SET `status` = 'pending' WHERE `comment`.`id` = $id";
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
                $del_check="select * from comment where id='$del_id'";
                $del_check_run=mysqli_query($conn, $del_check);
                if(mysqli_num_rows($del_check_run)>0){
                    $del_query="DELETE FROM comment WHERE id = '$del_id'";
                    if(isset($_SESSION['uname']) && $_SESSION['role']=='admin'){
                        if(mysqli_query($conn, $del_query)){
                            $msg="Comment has been deleted successfully";
                        }
                        else{
                            $error="Comment not deleted";
                        }
                    }
                }
                else{
                    echo "<script>window.top.location='index.php'</script>";
                }
            }
            if(isset($_GET['approve'])){
                $approve_id=$_GET['approve'];
                $approve_check="select * from comment where id='$approve_id'";
                $approve_check_run=mysqli_query($conn, $approve_check);
                if(mysqli_num_rows($approve_check_run)>0){
                    $approve_query="update comment set status='publish' where id='$approve_id'";
                    if(isset($_SESSION['uname']) && $_SESSION['role']=='admin'){
                        if(mysqli_query($conn, $approve_query)){
                            $msg="Comment has been Approved successfully";
                        }
                        else{
                            $error="Comment has been Approved";
                        }
                    }
                }
                else{
                    echo "<script>window.top.location='index.php'</script>";
                }
            }
            if(isset($_GET['unapprove'])){
                $unapprove_id=$_GET['unapprove'];
                $unapprove_check="select * from comment where id='$unapprove_id'";
                $unapprove_check_run=mysqli_query($conn, $unapprove_check);
                if(mysqli_num_rows($unapprove_check_run)>0){
                    $unapprove_query="update comment set status='pending' where id='$unapprove_id'";
                    if(isset($_SESSION['uname']) && $_SESSION['role']=='admin'){
                        if(mysqli_query($conn, $unapprove_query)){
                            $msg="Comment has been Unapproved successfully";
                        }
                        else{
                            $error="Comment has been Unapproved";
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
                    <h1><i class="fa fa-comments" aria-hidden="true"></i> Comments</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-comments" aria-hidden="true"></i> Comments</li>          
                    </ol>
                    <?php
                    if(isset($_GET['reply'])){
                        $reply_id=$_GET['reply'];
                        $reply_check="select * from comment where post_id='$reply_id'";
                        $reply_check_run=mysqli_query($conn, $reply_check);
                        if(mysqli_num_rows($reply_check_run)>0){
                            if(isset($_POST['reply'])){
                                $comment_data=$_POST['comment'];
                                if(empty($comment)){
                                    $get_user_data="select * from user where username='$session_uname'";
                                    $get_user_run=mysqli_query($conn, $get_user_data);
                                    $get_user_row=mysqli_fetch_row($get_user_run);
                                    $date=time();
                                    $first_name=$get_user_row[2];
                                    $last_name=$get_user_row[3];
                                    $full_name="$first_name $last_name";
                                    $email=$get_user_row[5];
                                    $image=$get_user_row[6];
                                    
                                    $insert_cmt_query="insert into comment(date, name, username, post_id, email, image, comment, status) values('$date', '$full_name', '$session_uname', '$reply_id', '$email', '$image', '$comment_data', 'publish')";
                                    
                                    if(mysqli_query($conn, $insert_cmt_query)){
                                        $cmt_msg="Comment has been submitted";
                                        echo "<script>window.top.location='comment.php'</script>";
                                    }
                                    else{
                                        $cmt_error="Comment has not been submitted";
                                    }
                                }
                            }
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-8 col-lg-8">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="comment">Comment:*</label>
                                    <?php
                                        if(isset($cmt_error))
                                            echo "<span class='pull-right' style='color:red;'>$cmt_error</span>";
                                        else if(isset($cmt_msg))
                                            echo "<span class='pull-right' style='color:green;'>$cmt_msg</span>";
                                    ?>
                                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="6" required></textarea>
                                </div>
                                <input type="submit" name="reply" class="btn btn-primary" value="Comment">
                            </form><hr>
                        </div>
                    </div>
                    <?php  
                        }
                    }
                    ?>                    
                                        
                    <?php 
                    $query="select * from comment order by id desc";
                    $run=mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($run)){
                        
                    ?>
                    <form action="" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12">
                            <div class="row">
                                <div class="col-xs-8 col-lg-4">
                                   <div class="form-group">
                                       <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="approve">Approve</option>
                                            <option value="unapprove">Unapprove</option>
                                        </select>
                                   </div>
                                    
                                </div>
                                <div class="col-xs-4 col-lg-8">
                                    <input type="submit" value="Apply" class="btn btn-success">
                                    
                                </div>
                            </div>                                           
                        </div>
                    </div><br><br>
                    <?php
                        if(isset($error))
                            echo "<span class='pull-right' style='color:red;'>$error</span>";
                        else if(isset($msg))
                            echo "<span class='pull-right' style='color:green;'>$msg</span>";
                    ?>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr >
                                <th><input id="selectallboxes" onClick="selectall(this)" type="checkbox"></th>
                                <th class="text-center">Sr #</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Comment</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Approve</th>
                                <th class="text-center">Unapprove</th>
                                <th class="text-center">Reply</th>
                                <th class="text-center">Del</th>
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
                                $uname=$row[3];
                                $comment=$row[8];
                                $status=$row[9];
                                $post_id=$row[4];
                            ?>    
                                <tr> 
                                    <td><input id="checkboxes" class="chk" name="checkboxes[]" value="<?php echo $id;?>" type="checkbox"></td>
                                    <td><?php echo $id;?></td>
                                    <td><?php echo "$day $month $year";?></td>
                                    <td><?php echo $uname;?></td>
                                    <td><?php echo $comment;?></td>
                                    <td style="color:<?php if($status=='publish'){echo 'green';}else{echo 'red';};?>"><?php echo ucfirst($status);?></td>
                                    <td><a href="comment.php?approve=<?php echo $id;?>"><i class="fa fa-check-circle" aria-hidden="true"></i></a></td>
                                    <td><a href="comment.php?unapprove=<?php echo $id;?>"><i class="fa fa-lock" aria-hidden="true"></i></a></td>
                                    <td><a href="comment.php?reply=<?php echo $post_id;?>"><i class="fa fa-reply" aria-hidden="true"></i></a></td>
                                    <td><a href="comment.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
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