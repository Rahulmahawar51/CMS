<?php
session_start();
require_once('inc/top.php'); 
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}

$username=$_SESSION['uname'];
$author_image=$_SESSION['author_image'];
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
                    <h1><i class="fa fa-plus-square" aria-hidden="true"></i> Add New Post</h1><hr>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>          
                        <li class="active"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Post</li>          
                    </ol>
                    
                  <?php
                    
                    if(isset($_POST['submit'])){
                        $date=time();
                        $title=mysqli_real_escape_string($conn,$_POST['title']);
                        $post_data=mysqli_real_escape_string($conn,$_POST['textarea']);
                        $category=$_POST['category'];
                        $tags=mysqli_real_escape_string($conn,$_POST['tags']);
                        $status=$_POST['status'];
                        $image=$_FILES['image']['name'];
                        $tmp_name=$_FILES['image']['tmp_name'];
                        //if(empty($title) or empty(post_data) or )
                        
                        $insert_query="insert into post(date, title, author, author_image, image, category, tags, post_data, views, status) values('$date','$title','$username','$author_image','$image','$category','$tags','$post_data','0','$status')";
                        if(mysqli_query($conn, $insert_query)){
                            $msg="Post has been submitted";
                            $path="img/$image";
                            if(move_uploaded_file($tmp_name, $path)){
                                copy($path, "../$path");
                            }
                            
                        }
                        else{
                            $error="Post has not been submitted";
                        }
                    }
                    ?>
                   <div class="row">
                       <div class="col-xs-12">
                           <form id="form" action="" method="post" enctype="multipart/form-data">
                               <div class="form-group">
                                   
                                   <?php
                                   if(isset($msg)){
                                       echo "<span class='pull-right' style='color:green;' >$msg</span>";
                                   }
                                   else if(isset($error)){
                                       echo "<span class='pull-right' style='color:red;' >$error</span>";
                                   }
                                   ?>
                                   <input type="text" name="title" class="form-control" placeholder="Type your post Title" required>
                               </div>
                               
                               <div class="form-group">
                                   <textarea name="textarea" id="tinymce" class="ckeditor" required></textarea>
                               </div>
                               <div class="row">
                                   <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="image">Post Image:</label>
                                           <input type="file" class="btn btn-file btn-default" name="image" required >
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
                                                       echo "<option value='$cat_name'>".ucfirst($cat_name)."</option>";
                                                        
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
                                           <input type="text" class="form-control" placeholder="Tags for your post" name="tags" required>
                                       </div>
                                   </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                           <label for="status">Status:</label>
                                           <select name="status" class="form-control" id="status">
                                               <option value="publish">publish</option>
                                               <option value="draft">draft</option>
                                           </select>
                                       </div>
                                   </div>
                               </div><br>
                               
                               <div class="row">
                                    <div class="col-md-offset-4 col-md-4">
                                        <div class="form-group">
                                            <input type="submit" name="submit" class="btn btn-block btn-primary" value="Submit Post">  
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