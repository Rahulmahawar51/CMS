<?php
session_start();
require_once('inc/top.php'); 
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
}


$cmt_tag_query="select * from comment where status='pending'";
$post_tag_query="select * from post";
$user_tag_query="select * from user";
$cat_tag_query="select * from category";

$cmt_tag_run=mysqli_query($conn, $cmt_tag_query);
$post_tag_run=mysqli_query($conn, $post_tag_query);
$user_tag_run=mysqli_query($conn, $user_tag_query);
$cat_tag_run=mysqli_query($conn, $cat_tag_query);

$cmt_tag_rows=mysqli_num_rows($cmt_tag_run);
$post_tag_rows=mysqli_num_rows($post_tag_run);
$user_tag_rows=mysqli_num_rows($user_tag_run);
$cat_tag_rows=mysqli_num_rows($cat_tag_run);

$post_tag_rows;
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
                    <h1><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</h1><hr>
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</li>          
                    </ol>

                    <div class="row tag-boxes">
                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-primary">
                               <div class="panel-heading">
                                   <div class="row">
                                       <div class="col-xs-3">
                                           <i class="fa fa-comments fa-5x"></i>
                                       </div>
                                       <div class="col-xs-9">
                                           <div class="text-right huge"><?php echo $cmt_tag_rows;?></div>
                                           <div class="text-right">Comments</div>
                                       </div>
                                   </div>
                               </div>
                               <a href="comment.php">
                                   <div class="panel-footer">
                                       <div class="pull-left">View All Comments</div>
                                       <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                                       <div class="clearfix"></div>
                                   </div>
                               </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-warning">
                               <div class="panel-heading">
                                   <div class="row">
                                       <div class="col-xs-3">
                                           <i class="fa fa-file-text fa-5x"></i>
                                       </div>
                                       <div class="col-xs-9">
                                           <div class="text-right huge"><?php echo $post_tag_rows;?></div>
                                           <div class="text-right">All posts</div>
                                       </div>
                                   </div>
                               </div>
                               <a href="post.php">
                                   <div class="panel-footer">
                                       <div class="pull-left">View All Posts</div>
                                       <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                                       <div class="clearfix"></div>
                                   </div>
                               </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-success">
                               <div class="panel-heading">
                                   <div class="row">
                                       <div class="col-xs-3">
                                           <i class="fa fa-users fa-5x"></i>
                                       </div>
                                       <div class="col-xs-9">
                                           <div class="text-right huge"><?php echo $user_tag_rows;?></div>
                                           <div class="text-right">Users</div>
                                       </div>
                                   </div>
                               </div>
                               <a href="user.php">
                                   <div class="panel-footer">
                                       <div class="pull-left">View All Users</div>
                                       <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                                       <div class="clearfix"></div>
                                   </div>
                               </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="panel panel-danger">
                               <div class="panel-heading">
                                   <div class="row">
                                       <div class="col-xs-3">
                                           <i class="fa fa-folder-open fa-5x"></i>
                                       </div>
                                       <div class="col-xs-9">
                                           <div class="text-right huge"><?php echo $cat_tag_rows;?></div>
                                           <div class="text-right">Categories</div>
                                       </div>
                                   </div>
                               </div>
                               <a href="category.php">
                                   <div class="panel-footer">
                                       <div class="pull-left">View All Categories</div>
                                       <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                                       <div class="clearfix"></div>
                                   </div>
                               </a>
                            </div>
                        </div>
                    </div>

                   <?php
                    
                    $get_users="select * from user order by id desc limit 5";
                    $get_user_run=mysqli_query($conn, $get_users);
                    if(mysqli_num_rows($get_user_run)>0){
                    ?>    
                    
                    <h3>New Users</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($get_user_row=mysqli_fetch_row($get_user_run)){
                                
                                $u_id=$get_user_row[0];
                                $u_date=getdate($get_user_row[1]);
                                $u_day=$u_date['mday'];
                                $u_mon=$u_date['month'];
                                $u_year=$u_date['year'];
                                $u_fname=$get_user_row[2];
                                $u_lname=$get_user_row[3];
                                $u_uname=$get_user_row[4];
                                $u_role=$get_user_row[8];
                            ?>
                                <tr>
                                    <td><?php echo $u_id;?></td>
                                    <td><?php echo "$u_day $u_mon, $u_year";?></td>
                                    <td><?php echo "$u_fname $u_lname";?></td>
                                    <td><?php echo $u_uname;?></td>
                                    <td><?php echo $u_role;?></td>
                                </tr>

                            <?php        
                                }
                            ?>
                            
                        </tbody>
                    </table>
                    <a href="user.php" class="btn btn-primary">View all users</a><hr>
                    <?php
                    }
                    ?>
                    
                    <?php
                    
                    $get_post="select * from post order by id desc limit 5";
                    $get_post_run=mysqli_query($conn, $get_post);
                    if(mysqli_num_rows($get_post_run)>0){
                    ?>  
                    <h3>New Posts</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Date</th>
                                <th>Post-Title</th>
                                <th>Category</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                while($get_post_row=mysqli_fetch_row($get_post_run)){
                                
                                $p_id=$get_post_row[0];
                                $p_date=getdate($get_post_row[1]);
                                $p_day=$p_date['mday'];
                                $p_mon=$p_date['month'];
                                $p_year=$p_date['year'];
                                $p_title=$get_post_row[2];
                                $p_cat=$get_post_row[6];
                                $p_view=$get_post_row[9];
                            ?>
                            <tr>
                                <td><?php echo $p_id;?></td>
                                <td><?php echo "$p_day $p_mon, $p_year";?></td>
                                <td><?php echo $p_title;?></td>
                                <td><?php echo $p_cat;?></td>
                                <td><?php echo $p_view;?></td>
                            </tr>
                            <?php        
                                }
                            ?>
                            
                        </tbody>
                    </table>
                    <a href="post.php" class="btn btn-primary">View all posts</a>
                    <?php
                    }
                    else{
                        echo "<h3>No posts available</h3>";
                    }
                    ?>
                    
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