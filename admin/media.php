<?php
session_start();
require_once('inc/top.php'); 
if(!isset($_SESSION['uname'])){
    echo "<script>window.top.location='login.php'</script>";
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
                    <h1><i class="fa fa-file-image-o" aria-hidden="true"></i> Media</h1><hr>
                    <ol class="breadcrumb">
                        <li ><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                        <li class="active"><i class="fa fa-file-image-o" aria-hidden="true"></i> Media</li>   
                    </ol>
                
                    <?php
                        if(isset($_POST['submit'])){
                            if(count($_FILES['media']['name'])>0){
                                for($i=0; $i<count($_FILES['media']['name']); $i++){
                                    $image=$_FILES['media']['name'][$i];
                                    $tmp_name=$_FILES['media']['tmp_name'][$i];
                                    
                                    $query="insert into media(image) values('$image')";
                                    if(mysqli_query($conn, $query)){
                                        $path="media/$image";
                                        if(move_uploaded_file($tmp_name, $path)){
                                            copy($path, "../$path");
                                        }
                                    }
                                }
                            }
                        }
                    ?>  
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="file" class="btn btn-default btn-file" name="media[]" required multiple>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" name="submit" value="Add media" class="btn btn-primary">
                            </div>
                        </div>       
                    </form><br>
                    <div class="row">
                    <?php
                        $get_query="select * from media order by id desc";
                        $get_run=mysqli_query($conn, $get_query);
                        if(mysqli_num_rows($get_run)){
                            while($row=mysqli_fetch_row($get_run)){
                                $get_image=$row[1];
                                
                            ?>
                            
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 thumb">
                                    <a href="media/<?php echo $get_image;?>" class="thumbnail">
                                        <img src="media/<?php echo $get_image;?>" width="100%" alt="">
                                    </a>
                                </div>
                          
                            <?php    
                            }
                        }
                    ?>
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