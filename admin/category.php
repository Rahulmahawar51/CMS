<?php 
session_start();

require_once('inc/top.php');
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}
if(isset($_SESSION['uname']) && $_SESSION['role']=='author'){
    echo "<script>window.top.location='index.php'</script>";
}

if(isset($_GET['del'])){
    $del_id=$_GET['del'];
    if(isset($_SESSION['uname']) && $_SESSION['role']=='admin'){
        $del_query="delete from category where id='$del_id'";
        if(mysqli_query($conn, $del_query))
            $del_msg="Categroy Deleted";
        else
            $del_error="Not Deleted";
    }
}

if(isset($_GET['edit'])){
    $edit_id=$_GET['edit'];
    
    
}

if(isset($_POST['update'])){
    $cat_name=mysqli_real_escape_string($conn,$_POST['cat-name']);
    
    $check_query="select * from category where category='$cat_name'";
    $check_run=mysqli_query($conn,$check_query);
    if(mysqli_num_rows($check_run)>0){
        $up_error="Category already exits";
    }
    else{
        $update_query="update category set category='$cat_name' where id='$edit_id'";
        if(mysqli_query($conn, $update_query)){
            $up_msg="Category has been updated successfully";
        }
        else{
            $up_error="Category has not been updated";
        }
    }
}

if(isset($_POST['submit'])){
    $cat_name=mysqli_real_escape_string($conn,$_POST['cat-name']);
    
    $check_query="select * from category where category='$cat_name'";
    $check_run=mysqli_query($conn,$check_query);
    if(mysqli_num_rows($check_run)>0){
        $error="Category already exits";
    }
    else{
        $insert_query="insert into category(category) values('$cat_name')";
        if(mysqli_query($conn, $insert_query)){
            $msg="Category has been added successfully";
        }
        else{
            $error="Category has not been added";
        }
    }
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
                    <h1><i class="fa fa-folder-open" aria-hidden="true"></i> Categories</h1><hr>
                    <ol class="breadcrumb">
                        <li ><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                        <li class="active"><i class="fa fa-folder-open" aria-hidden="true"></i> Categories</li>          
                    </ol>
                    
                    <div class="row">
                        <div class="col-md-6">
                           
                            <form action="" method="post">
                                <div class="form-group">
                                   <?php
                                        if(isset($error))
                                            echo "<span class='pull-right' style='color: red;'>$error</span>";
                                        else if(isset($msg)){
                                            echo "<span class='pull-right' style='color: green;'>$msg</span>";
                                        }
                                    ?>
                                    <label for="category">Category Name:</label>
                                    <input type="text" name="cat-name" class="form-control" placeholder="Enter Category Name" required>
                                </div>
                                <input type="submit" name="submit" value="Create Category" class="btn btn-primary">
                            </form><br><br>
                        
                           <?php
                                if(isset($_GET['edit'])){
                                    $edit_check="select * from category where id='$edit_id'";
                                    $edit_run=mysqli_query($conn, $edit_check);
                                    
                                    if(mysqli_num_rows($edit_run)>0){
                                        $edit_row=mysqli_fetch_row($edit_run);
                                        $edit_cat=$edit_row[1];
                                        $edit_id=$edit_id[0];
                                ?>    
                                    <form action="" method="post">
                                        <div class="form-group">
                                           <?php
                                                if(isset($up_error))
                                                    echo "<span class='pull-right' style='color: red;'>$up_error</span>";
                                                else if(isset($up_msg)){
                                                    echo "<span class='pull-right' style='color: green;'>$up_msg</span>";
                                                }
                                            ?>
                                            <label for="category">Update Category Name:</label>
                                            <input value="<?php echo $edit_cat;?>" type="text" name="cat-name" class="form-control" placeholder="Enter Category Name" required>
                                        </div>
                                        <input type="submit" name="update" value="Upadte Category" class="btn btn-primary">
                                    </form>
                                <?php
                                    }
                                }
                            ?>
                            
                            
                        </div>
                        <div class="col-md-6">
                            
                            <?php
                            
                                $get_query="select * from category order by id desc";
                                $get_run=mysqli_query($conn, $get_query);
                                if(mysqli_num_rows($get_run)>0){
                        
                                    if(isset($del_error))
                                        echo "<span class='pull-right' style='color: red;'>$del_error</span>";
                                    else if(isset($del_msg)){
                                        echo "<span class='pull-right' style='color: green;'>$del_msg</span>";
                                    }
                                ?>    
                                
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Category Name</th>
                                        <th>Posts</th>
                                        <th>Edit</th>
                                        <th>Del</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                    while($get_row=mysqli_fetch_row($get_run)){
                                        $get_id=$get_row[0];
                                        $get_cat=$get_row[1];
                                       
                                        
                                    ?>    
                                        <tr>
                                            <td><?php echo $get_id;?></td>
                                            <td><?php echo ucfirst($get_cat);?></td>
                                            <td>15</td>
                                            <td><a href="category.php?edit=<?php echo $get_id;?>"><i class="fa fa-pencil"></i></a></td>
                                            <td><a href="category.php?del=<?php echo $get_id;?>"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>                                    
                                </tbody>
                            </table>
                               <?php
                                }
                                else{
                                    echo "<center><h3>No Category Found</h3></center>";
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