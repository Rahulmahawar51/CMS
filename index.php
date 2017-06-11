<?php require_once("inc/top.php");?>
  </head>
  <body>
    <?php require_once("inc/nav.php");
      
      $no_of_post=3;
      
    
      if(isset($_GET['cat'])){
          $cat_id=$_GET['cat'];
          $cat_query="select * from category where id=$cat_id";
          $cat_run=mysqli_query($conn, $cat_query);
          $cat_row=mysqli_fetch_array($cat_run);
          $cat_name=$cat_row[1];    
      }
      
      if(isset($_GET['page'])){
          $page_id=$_GET['page'];
      }
      else{
          $page_id=1;
      }
      
      if(isset($_POST["search"])){
          $search=$_POST["search_title"];
          $all_p_query="select * from post where status='publish'";
          $all_p_query.="and tags LIKE '%$search%'";
          $all_p_run=mysqli_query($conn, $all_p_query);
          $all_post=mysqli_num_rows($all_p_run);
          $total_pages=ceil($all_post / $no_of_post);

          $post_start_from=($page_id-1)*$no_of_post;
      }
      else{
          $all_p_query="select * from post where status='publish'";
          if(isset($cat_name)){
              $all_p_query.="and category = '$cat_name'";
          }
          $all_p_run=mysqli_query($conn, $all_p_query);
          $all_post=mysqli_num_rows($all_p_run);
          $total_pages=ceil($all_post / $no_of_post);

          $post_start_from=($page_id-1)*$no_of_post;
      }
      
      ?>
    
    <div class="jumbotron">
        <div class="container">
            <div id="detail" class="animated slideInLeft">
                <h1>Trendy <span>Blog</span></h1>
            </div>
        </div>
        <img src="img/Header-Images-Blog-seperate-061.jpg" alt="header">
    </div>
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                   
                   <?php
                    $slider_query="select * from post where status='publish' order by id desc limit 5";
                    $slider_run=mysqli_query($conn, $slider_query);
                    if(mysqli_num_rows($slider_run)>0){
                     
                        $count=mysqli_num_rows($slider_run);
        
                    ?>   
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                      <!-- Indicators -->
                      <ol class="carousel-indicators">
                        <?php
                          
                          for($i=0;$i<$count;$i++){
                              if($i==0){
                                  echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."' class='active'></li>";
                              }
                              else{
                                  echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."'></li>";
                              }
                          }
                        
                          ?>
                        
                      </ol>

                      <!-- Wrapper for slides -->
                      
                      <div class="carousel-inner" role="listbox">
                       
                       <?php
                        $check=0;
                        
                        while($slider_row=mysqli_fetch_row($slider_run)){    
                            
                            $check=$check+1;
                            
                            if($check==1){
                                echo "<div class='item active'>";
                            }
                            else{
                                echo "<div class='item'>";
                            }
                            
                            $slider_id=$slider_row[0];
                            $slider_image=$slider_row[5];
                            $slider_title=$slider_row[2];
                        ?>
                        
                          <a href="post.php?post_id=<?php echo $slider_id;?>"><img src="img/<?php echo $slider_image; ?>" alt="..." width="100%" height="400px"></a>
                          <div class="carousel-caption">
                            <p><?php echo $slider_title; ?></p>
                          </div>
                        </div>   
                        
                        <?php        
                        }         
                        ?>
                        
                      </div>

                      <!-- Controls -->
                      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                    
                    <?php
                    }

                    if(isset($_POST["search"])){
                        $search=$_POST["search_title"];
                        $query="select * from post where status='publish'" ;
                        $query.="and tags LIKE '%$search%'";
                        $query.="order by id desc limit $post_start_from,$no_of_post";
                    }
                    else{
                        $query="select * from post where status='publish'" ;
                        if(isset($_GET['cat'])){
                            $query.="and category='$cat_name'";
                        }
                        $query.="order by id desc limit $post_start_from,$no_of_post";
                    }
                    $run=mysqli_query($conn,$query);
                    if(mysqli_num_rows($run)>0){
                        while($row=mysqli_fetch_array($run)){
                            $id=$row[0];
                            $date=getdate($row[1]);
                            $day = $date['mday'];
                            $mon = $date['month'];
                            $year = $date['year'];
                            
                            $title=$row[2];
                            $author=$row[3];
                            $author_image=$row[4];
                            $image=$row[5];
                            $category=$row[6];
                            $tags=$row[7];
                            $post_data=$row[8];
                            $views=$row[9];
                            $status=$row[10]; 
                            
                    ?>
                    <div class="post">
                        <div class="row">
                            <div class="col-md-2 post-date">
                                <div id="day"><?php echo $day?></div>
                                <div id="month"><?php echo $mon?></div>
                                <div id="year"><?php echo $year?></div>
                            </div>
                            <div class="col-md-8 post-title">
                                <a href="post.php?post_id=<?php echo $id?>"><h2><?php echo $title?></h2></a>
                                <p>Written by : <span><?php echo ucfirst($author)?></span></p>
                            </div>
                            <div class="col-md-2 profile">
                                <img src="img/<?php echo $author_image?>" alt="profile" class="img-circle" width="60%">
                            </div>
                            
                        </div>
                        <a href="post.php?post_id=<?php echo $id?>"><img src="img/<?php echo $image?>" alt="post" ></a>
                        <div class="text">
                            <?php echo substr($post_data,0,400)."....."?>
                        </div>
                        <a href="post.php?post_id=<?php echo $id?>">
                            <div class="btn btn-primary">Read more..</div>
                        </a>
                        <div class="bottom">
                            <span><i class="fa fa-folder" aria-hidden="true"></i> <a href="" class="txt-info"><?php echo ucfirst($category)?></a></span>
                            |<span><i class="fa fa-commenting" aria-hidden="true"></i> <a href="" class="txt-info">Comment</a></span>
                        </div>
                    </div>
                    
                    <?php    
                        }
                    }
                    else{
                        echo "<center><h2>No Posts available yet..</h2></center>";
                    }
                    ?>
                                                    
                    <nav aria-label="Page navigation" class="paging">
                      <ul class="pagination">
                        <!--<li>
                          <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>-->
                        
                        <?php                    
                        for($i=1;$i<=$total_pages;$i++){
                            echo "<li class='".($page_id==$i ? 'active' : '')."'><a href='index.php?page=$i&".(isset($cat_id) ? "cat=$cat_id" : "")."'>$i</a></li>";
                        }  
                        ?>
                        <!--<li>
                          <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>-->
                      </ul>
                    </nav>
                    
                </div>
                
                <div class="col-md-4">
                    
                    <?php require_once("inc/sidebar.php");?>
                </div>
            </div>
        </div>
    </section>
    <?php require_once("inc/footer.php");?>
    
    <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>