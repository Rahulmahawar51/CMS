
<?php
$get_comment="select * from comment where status = 'pending' ";
$get_cmt_run=mysqli_query($conn, $get_comment);
$num_cmt=mysqli_num_rows($get_cmt_run);
$session_role2=$_SESSION['role'];
?>
 <div class="list-group">
  <a href="index.php" class="list-group-item active">
    <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
  </a>
  <a href="post.php" class="list-group-item">
     
      <i class="fa fa-file" aria-hidden="true"></i> All posts
  </a>
  <?php
     if(isset($_SESSION['role']) and $session_role2=='admin'){
     ?>
     <a href="comment.php" class="list-group-item">
      <?php
         if($num_cmt>0){
             echo "<span class='badge'>".$num_cmt."</span>";
         }
         ?>
      
      <i class="fa fa-comments" aria-hidden="true"></i> Comments
  </a>
  <a href="category.php" class="list-group-item">
      
      <i class="fa fa-folder-open" aria-hidden="true"></i> Categories
  </a>
  <a href="user.php" class="list-group-item">
      
      <i class="fa fa-users" aria-hidden="true"></i> Users
  </a>
     <?php
     }
     ?>
  
</div>