<?php 
session_start();
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}

require_once('inc/top.php'); 
$session_uname=$_SESSION['uname'];
?>

<?php
    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $id){
            
            $bulk_option = $_POST['bulk-options'];
               
            if($bulk_option=='delete'){
                $bulk_del_query="DELETE FROM `post` WHERE `post`.`id` = $id";
                mysqli_query($conn, $bulk_del_query);
            }
            else if($bulk_option=='publish'){
                $bulk_author_query="UPDATE `post` SET `status` = 'publish' WHERE `post`.`id` = $id";
                mysqli_query($conn, $bulk_author_query);
            }
            else if($bulk_option=='draft'){
                $bulk_admin_query="UPDATE `post` SET `status` = 'draft' WHERE `post`.`id` = $id";
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
                if($_SESSION['role']=='admin'){
                    $del_check="select * from post where id='$del_id'";
                    $del_check_run=mysqli_query($conn, $del_check);
                }
                if($_SESSION['role']=='author'){
                    $del_check="select * from post where id='$del_id' and author='$session_uname'";
                    $del_check_run=mysqli_query($conn, $del_check);
                }
                if(mysqli_num_rows($del_check_run)>0){
                    $del_query="DELETE FROM post WHERE id = '$del_id'";
                if(mysqli_query($conn, $del_query)){
                    $msg="Post has been deleted successfully";
                }
                else{
                    $error="Post not deleted";
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
                    <h1><i class="fa fa-file" aria-hidden="true"></i> Posts</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-file" aria-hidden="true"></i> Posts</li>          
                    </ol>
                    
                    <?php 
                    
                    if($_SESSION['role']=='admin'){
                        $query="select * from post order by id desc";
                        $run=mysqli_query($conn, $query);
                    }
                    else if($_SESSION['role']=='author'){
                        $query="select * from post where author='$session_uname' order by id desc";
                        $run=mysqli_query($conn, $query);
                    }
                    if(mysqli_num_rows($run)){
                        
                    ?>
                    <form action="" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-lg-8">
                            <div class="row">
                                <div class="col-lg-4 col-xs-8">
                                   <div class="form-group">
                                       <select name="bulk-options" id="" class="form-control">
                                            <option value="delete">Delete</option>
                                            <option value="publish">Publish</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                   </div>
                                    
                                </div>
                                <div class="col-xs-4 col-lg-8">            
                                   <input type="submit" value="Apply" class="btn btn-success">   
                                    <a href="add-post.php" class="btn btn-primary">Add new</a>
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
                                <th>Title</th>
                                <th>Author</th>
                                <th>image</th>
                                <th>Category</th>
                                <th>Views</th>
                                <th>Status</th>
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
                                
                                $title=$row[2];
                                $author=$row[3];
                                $image=$row[5];
                                $category=$row[6];
                                $view=$row[9];
                                $status=$row[10];
                            ?>    
                                <tr> 
                                    <td><input id="checkboxes" class="chk" name="checkboxes[]" value="<?php echo $id;?>" type="checkbox"></td>
                                    <td><?php echo $id;?></td>
                                    <td><?php echo "$day $month $year";?></td>
                                    <td><?php echo "$title";?></td>
                                    <td><?php echo $author;?></td>
                                    <td><img src="img/<?php echo $image;?>" width="30px" alt=""></td>
                                    <td><?php echo ucfirst($category);?></td>
                                    <td><?php echo $view;?></td>
                                    <td style="color:<?php if($status=='publish'){echo 'green';}else{echo 'red';};?>"><?php echo ucfirst($status);?></td>
                                    <td><a href="edit-post.php?edit=<?php echo $id;?>"><i class="fa fa-pencil"></i></a></td>
                                    <td><a href="post.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
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