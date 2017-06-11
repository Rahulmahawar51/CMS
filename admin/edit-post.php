<?php
ob_start();
session_start();
require_once('inc/top.php'); 
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}

$username=$_SESSION['uname'];
$session_role=$_SESSION['role'];
$author_image=$_SESSION['author_image'];

if(isset($_GET['edit'])){
    $get_id=$_GET['edit'];
    if($_SESSION['role']=='admin'){
        $get_query="select * from post where id='$get_id'";
        $get_run=mysqli_query($conn, $get_query);
    }
    else if($_SESSION['role']=='author'){
        $get_query="select * from post where id='$get_id' and author='$username'";
        $get_run=mysqli_query($conn, $get_query);
    }
    if(mysqli_num_rows($get_run)>0){
        $get_row=mysqli_fetch_row($get_run);
        $title=$get_row[2];
        $post_data=$get_row[8];
        $image=$get_row[5];
        $tags=$get_row[7];
        $category=$get_row[6];
        $status=$get_row[10];
    }
    else{
        echo "<script>window.top.location='post.php'</script>";
    }
}
?>
<script>
     function submit() {
        tinyMCE.triggerSave();
        $('$myform').submit();
    }
</script>
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
                    <h1><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Post</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Post</li>          
                    </ol>

                  <?php
                    
                    if(isset($_POST['update'])){
                        $up_title=mysqli_real_escape_string($conn,$_POST['title']);
                        $up_post_data=mysqli_real_escape_string($conn,$_POST['textarea']);
                        $up_category=$_POST['category'];
                        $up_tags=mysqli_real_escape_string($conn,$_POST['tags']);
                        $up_status=$_POST['status'];
                        $up_image=$_FILES['image']['name'];
                        $up_tmp_name=$_FILES['image']['tmp_name'];
                        //if(empty($title) or empty(post_data) or )
                        if(empty($up_image)){
                            $up_image=$image;
                        }
                        $update_query="update post set title='$up_title', image='$up_image', category='$up_category', tags='$up_tags', post_data='$up_post_data', status='$up_status' where id='$get_id'";
                        if(mysqli_query($conn, $update_query)){
                            $msg="Post has been Updated";
                            $path="img/$up_image";
                            header("refresh:0; url=edit-post.php?edit=$get_id");
                            if(!empty($up_image)){
                                if(move_uploaded_file($up_tmp_name, $path)){
                                    copy($path, "../$path");
                                }
                            }
                            
                        }
                        else{
                            $error="Post has not been Updated";
                        }
                    }
                    ?>
                   <div class="row">
                       <div class="col-xs-12">
                           <form id="myform" action="" method="post" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label for="title">Title:*</label>
                                   <?php
                                   if(isset($msg)){
                                       echo "<span class='pull-right' style='color:green;' >$msg</span>";
                                   }
                                   else if(isset($error)){
                                       echo "<span class='pull-right' style='color:red;' >$error</span>";
                                   }
                                   ?>
                                   <input type="text" value="<?php if(isset($title)){echo $title;};?>" name="title" class="form-control" placeholder="Type your post title" required>
                               </div>
                               <div class="form-group">
                                    <a href="media.php" class="btn btn-primary">Add Media</a>
                               </div>
                               <div class="form-group">
                                   <textarea name="textarea" id="tinymce" class="ckeditor" cols="30" rows="10" required><?php if(isset($post_data)){echo $post_data;};?></textarea>
                               </div>
                               <div class="row">
                                   <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="image">Post Image:</label>
                                           <input type="file" class="btn btn-file btn-default" name="image" >
                                       </div>
                                   </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="categories">Categories:</label>
                                           <select name="category" class="form-control" id="category">
                                               <?php
                                               $cat_query="select * from category order by id desc";
                                               $cat_run=mysqli_query($conn, $cat_query);
                                               
                                               if(mysqli_num_rows($cat_run)>0){
                                                   while($cat_row=mysqli_fetch_row($cat_run)){
                                                       $cat_name=$cat_row[1];
                                                       echo "<option value='$cat_name'".((isset($category) and $category==$cat_name)? 'selected' : '' ).">".ucfirst($cat_name)."</option>";   
                                                   }
                                               }
                                               else{
                                                   echo "<h5>No Categories</h5>";
                                               }
                                               ?>
                                               
                                           </select>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="tags">Tags:*</label>
                                           <input type="text" value="<?php if(isset($tags)){echo $tags;};?>"  class="form-control" placeholder="Tags for your post" name="tags" required>
                                       </div>
                                   </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="status">Status:</label>
                                           <select name="status" class="form-control" id="status">
                                               <option value="publish" <?php if(isset($status) and $status=='publish'){echo 'selected';};?>>publish</option>
                                               <option value="draft" <?php if(isset($status) and $status=='draft'){echo 'selected';};?>>draft</option>
                                           </select>
                                       </div>
                                   </div>
                               </div><br>
                               
                               <div class="row">
                                    <div class="col-md-offset-4 col-md-4">
                                        <div class="form-group">
                                            <input type="submit" name="update" class="btn btn-block btn-primary" value="Update Post">  
                                        </div>
                                   </div>
                               </div>
                               
                           </form>
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