<?php require_once("inc/top.php");?>
  </head>
  <body>
    
    <?php require_once("inc/nav.php");
      
    if(isset($_GET['post_id'])){
        $pst_id=$_GET['post_id'];
        $view_query="update post set views=views+1 where id=$pst_id";
        mysqli_query($conn, $view_query);
        
        $pst_query="select * from post where status='publish' and id=$pst_id";
        $pst_run=mysqli_query($conn, $pst_query);
        
        if(mysqli_num_rows($pst_run)>0){
            $pst_row=mysqli_fetch_array($pst_run);
            $pst_date=getdate($pst_row[1]);
            $pst_day=$pst_date['mday'];
            $pst_mon=$pst_date['month'];
            $pst_year=$pst_date['year'];

            $pst_title=$pst_row[2];
            $pst_author=$pst_row[3];
            $pst_author_image=$pst_row[4];
            $pst_image=$pst_row[5];
            $pst_category=$pst_row[6];
            $pst_post_data=$pst_row[8];
        }
        else{
            echo "<script>window.top.location='index.php'</script>";
        }
        
    }
    ?>
    <div class="jumbotron">
        <div class="container">
            <div id="detail" class="animated slideInLeft">
                <h1>Custom <span>Post</span></h1>
            </div>
        </div>
        <img src="img/Header-Images-Blog-seperate-061.jpg" alt="header">
    </div>
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="post">
                        <div class="row">
                            <div class="col-md-2 post-date">
                                <div id="day"><?php echo $pst_day;?></div>
                                <div id="month"><?php echo $pst_mon;?></div>
                                <div id="year"><?php echo $pst_year;?></div>
                            </div>
                            <div class="col-md-8 post-title">
                                <a href="post.php?post_id=<?php echo $pst_id;?>"><h1><?php echo $pst_title;?> </h1></a>
                                <p>Written by : <span><?php echo ucfirst($pst_author);?></span></p>
                            </div>
                            <div class="col-md-2 profile">
                                <img src="img/<?php echo $pst_author_image;?>" alt="profile" class="img-circle" width="60%">
                            </div>
                            
                        </div>
                        <a href="img/<?php echo $pst_image;?>"><img src="img/<?php echo $pst_image;?>" alt="post" ></a>
                        <div class="text">
                            <?php echo $pst_post_data;?>
                        </div>
                        
                        <div class="bottom">
                            <span><i class="fa fa-folder" aria-hidden="true"></i> <a href="" class="txt-info"><?php echo ucfirst($pst_category);?></a></span>
                            |<span><i class="fa fa-commenting" aria-hidden="true"></i> <a href="" class="txt-info">Comment</a></span>
                        </div>
                    </div>
                    
                    <div class="related-post">
                       <h3>Related Posts</h3><hr>
                        <div class="row">
                            
                            <?php
                            
                            $r_query="select * from post where status='publish' and title like '%$pst_title%' limit 3";
                            $r_run= mysqli_query($conn, $r_query);
                            if(mysqli_num_rows($r_run)>0){
                                while($r_row = mysqli_fetch_row($r_run)){
                                    $r_id=$r_row[0];
                                    $r_title=$r_row[2];
                                    $r_image=$r_row[5];
                                    ?> 
                                    <div class="col-md-4">
                                        <a href="post.php?post_id=<?php echo $r_id; ?>">
                                            <img src="img/<?php echo $r_image; ?>" alt="">
                                            <h4><?php echo $r_title; ?></h4>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            
                        </div>
                    </div>
                    
                    <div class="author">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="img/<?php echo $pst_author_image; ?>" class="img-circle" alt="profile">
                            </div>
                            <div class="col-sm-9">
                                <h4 class="txt-primary"><?php echo ucfirst($pst_author); ?></h4>
                                
                                <?php
                                
                                $bio_query="select * from user where username='$pst_author'";
                                $bio_run=mysqli_query($conn, $bio_query);
                                if(mysqli_num_rows($bio_run)){
                                    $bio_row=mysqli_fetch_row($bio_run);
                                    $details=$bio_row[9];
                                ?>    
                                    <p class="text1">
                                        <?php echo $details;?>
                                    </p>
                                <?php
                                }                            
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="comment">
                       <h3>Comment</h3><hr>
                           <?php
                            
                            $c_query="select * from comment where status='publish' and post_id=$pst_id";
                            $c_run= mysqli_query($conn, $c_query);
                            if(mysqli_num_rows($c_run)){
                                while($c_row=mysqli_fetch_row($c_run)){
                                    $c_id=$c_row[0];
                                    $c_name=$c_row[2];
                                    $c_username=$c_row[3];
                                    $c_image=$c_row[7];
                                    $c_comment=$c_row[8];
                                ?>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img class="img-circle" src="img/<?php echo $c_image;?>" alt="profile">
                                        </div>
                                        <div class="col-sm-10">
                                            <h4><?php echo ucfirst($c_username);?></h4>
                                            <p class="text1">
                                                <?php echo $c_comment;?>    
                                            </p>
                                        </div>
                                    </div><hr>
                                <?php
                                }
                            }
                            ?> 
                    </div>
                    
                    <?php
                    if(isset($_POST['sub'])){
                        $cs_name=$_POST['name'];
                        $cs_email=$_POST['email'];
                        $cs_website=$_POST['website'];
                        $cs_comment=$_POST['message'];
                        $cs_date=time();
                        if(empty($cs_name) or empty($cs_email) or empty($cs_comment)){
                            $error="ALL (*) values are required";
                        }
                        else{
                            $cs_query="INSERT INTO comment VALUES (NULL, '$cs_date', '$cs_name', 'user', '$pst_id', '$cs_email', '$cs_website', 'author1.jpg', '$cs_comment', 'pending')";
                            if(mysqli_query($conn, $cs_query)){
                                $msg="Submitted and pending";
                                $cs_name="";
                                $cs_email="";
                                $cs_website="";
                                $cs_comment="";
                            }
                            else{
                                $error="Comment not submitted";
                            }
                        }
                    }
                    ?>
                    <div class="form">
                        <div class="row">
                            <div class="col-md-12 ">
                               <h3 class="txt-primary">Contact Form</h3><hr>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="fullname">Full Name:*</label>
                                        <input type="text" name="name" value="<?php if(isset($cs_name)){echo $cs_name;} ?>" placeholder="Your Full Name" class="form-control" id="fullname">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:*</label>
                                        <input type="text" value="<?php if(isset($cs_email)){echo $cs_email;} ?>" name="email" placeholder="Email" class="form-control" id="fullname">
                                    </div>

                                    <div class="form-group">
                                        <label for="website">Website:</label>
                                        <input type="text" value="<?php if(isset($cs_website)){echo $cs_website;} ?>" name="website" placeholder="Website" class="form-control" id="fullname">
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Message:*</label>
                                        <textarea name="message" name="message" class="form-control" placeholder="Your message should be here!" id="message" cols="30" rows="10"><?php if(isset($cs_message)){echo $cs_message;} ?></textarea>
                                    </div>
                                    <input type="submit" name="sub" value="Submit" class="btn btn-primary">
                                    <?php
                                    if(isset($error)){
                                        echo "<span style='color:red;' class='pull-right'>$error</span>";
                                    }
                                    else if(isset($msg)){
                                        echo "<span style='color:green;' class='pull-right'>$msg</span>";
                                    }
                                    ?>
                                    
                                </form>

                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-4">
                    <?php require_once('inc/sidebar.php'); ?>
                </div>
            </div>
        </div>
    </section>
   
    <?php require_once('inc/footer.php'); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

