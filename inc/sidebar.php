<div class="widgets">
   <form action="index.php" method="post">
      <div class="input-group">
         <?php 
          if(isset($_POST["search"])){
            $search=$_POST["search_title"];
          }
          ?>
          <input type="text" class="form-control" name="search_title" placeholder="<?php echo isset($search) ? $search : 'Search for...';?>">
          <span class="input-group-btn">
            <input type="submit" name="search" class="btn btn-primary" value="GO">
          </span>
      </div><!-- /input-group --> 
   </form>
    
</div><!--widger closed-->

<div class="widgets">
    <div class="popular">
       <h3>Popular posts</h3>
       
       <?php
        
        $r_query="select * from post where status='publish' order by views desc limit 5";
        $r_run=mysqli_query($conn, $r_query);
        
        if( mysqli_num_rows($r_run)>0){

            while($r_row=mysqli_fetch_row($r_run)){
                $r_id=$r_row[0];
                $r_image=$r_row[5];
                $r_title=$r_row[2];
                $r_date=getdate($r_row[1]);
                $r_day=$r_date['mday'];
                $r_mon=$r_date['month'];
                $r_year=$r_date['year'];
            
        ?>    
            <hr>
            <div class="row">
                <div class="col-xs-4">
                    <a href="post.php?post_id=<?php echo $r_id; ?>"><img src="img/<?php echo $r_image; ?>" width="100%" height="60px" alt="dog"></a>
                </div>
                <div class="col-xs-8 detail">
                    <a href="post.php?post_id=<?php echo $r_id; ?>"><h5><?php echo $r_title; ?></h5></a>
                    <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $r_day." ".$r_mon." ,".$r_year;?></p>
                </div>
            </div>
        
        <?php
            }    
        }
        ?>
       
    </div>
</div><!--widger closed-->

<div class="widgets">
    <div class="popular">
       <h3>Recent posts</h3>
       
       <?php
        
        $r_query="select * from post where status='publish' order by id desc limit 5";
        $r_run=mysqli_query($conn, $r_query);
        
        if( mysqli_num_rows($r_run)>0){

            while($r_row=mysqli_fetch_row($r_run)){
                $r_id=$r_row[0];
                $r_image=$r_row[5];
                $r_title=$r_row[2];
                $r_date=getdate($r_row[1]);
                $r_day=$r_date['mday'];
                $r_mon=$r_date['month'];
                $r_year=$r_date['year'];
            
        ?>    
            <hr>
            <div class="row">
                <div class="col-xs-4">
                    <a href="post.php?post_id=<?php echo $r_id; ?>"><img src="img/<?php echo $r_image; ?>" width="100%" height="60px" alt="dog"></a>
                </div>
                <div class="col-xs-8 detail">
                    <a href="post.php?post_id=<?php echo $r_id; ?>"><h5><?php echo $r_title; ?></h5></a>
                    <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $r_day." ".$r_mon." ,".$r_year;?></p>
                </div>
            </div>
        
        <?php
            }    
        }
        ?>
       
    </div>
</div><!--widger closed-->

<div class="widgets">
    <div class="popular">
       <h3>Categories</h3>
       <hr>
       <div class="row">
           <div class="col-xs-6">
               <ul>
                   <?php
                   
                   $c_query="select * from category";
                   $c_run=mysqli_query($conn, $c_query);
                   
                   if(mysqli_num_rows($c_run)>0){
                       $check=0;
                       while($c_row=mysqli_fetch_row($c_run)){
                           $c_id=$c_row[0];
                           $c_category=$c_row[1];
                           $check++;
                           if($check%2==1){
                               echo "<li><a href='index.php?cat=$c_id'>".ucfirst($c_category)."</a></li>";
                           }    
                       }
                   }
                   
                   ?>
               </ul>
           </div>
           <div class="col-xs-6">
               <ul>
                   <?php
                   
                   $c_query="select * from category";
                   $c_run=mysqli_query($conn, $c_query);
                   
                   if(mysqli_num_rows($c_run)>0){
                       $check=0;
                       while($c_row=mysqli_fetch_row($c_run)){
                           $c_id=$c_row[0];
                           $c_category=$c_row[1];
                           $check++;
                           if($check%2==0){
                               echo "<li><a href='index.php?cat=$c_id'>".ucfirst($c_category)."</a></li>";
                           }    
                       }
                   }
                   
                   ?>
               </ul>
           </div>
       </div>
    </div>
</div><!--widger closed-->

<div class="widgets">
    <div class="popular">
       <h3>Social Contacts</h3>
       <hr>
        <div class="row">
            <div class="col-xs-3">
                <a href="https://www.facebook.com/rmahawar190"><i class="fa fa-facebook-square fa-3x" aria-hidden="true"></i></a>
            </div>
            <div class="col-xs-3">
                <a href=""><i class="fa fa-twitter-square fa-3x" aria-hidden="true"></i></a>
            </div>
            <div class="col-xs-3">
                <a href="https://plus.google.com/u/0/107102001844406748762"><i class="fa fa-google-plus-square fa-3x" aria-hidden="true"></i></a>
            </div>
            <div class="col-xs-3">
                <a href="https://www.linkedin.com/in/rahul-mahawar-078aa1120/"><i class="fa fa-linkedin-square fa-3x" aria-hidden="true"></i></i></a>
            </div>
        </div>
    </div>
</div><!--widger closed-->
                    