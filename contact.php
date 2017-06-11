<?php require_once("inc/top.php");?>
  </head>
  <body>
    <?php require_once("inc/nav.php");?>
    
    <div class="jumbotron">
        <div class="container">
            <div id="detail" class="animated slideInLeft">
                <h1>Contact <span>Us</span></h1>
            </div>
        </div>
        <img src="img/Header-Images-Blog-seperate-061.jpg" alt="header">
    </div>
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBpca6jLmZpwJauWS4IuL733piOq7SZjmU '></script><div style='overflow:hidden;height:400px;width:100%;'><div id='gmap_canvas' style='height:400px;width:100%;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> <a href='https://indiatvnow.com/'>&nbsp;</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=9f801d3adba67f5b0f0226ffb934de79d696fa86'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:12,center:new google.maps.LatLng(29.9489654,76.81728429999998),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(29.9489654,76.81728429999998)});infowindow = new google.maps.InfoWindow({content:'<strong>Kurukshetra, Haryana</strong><br>NIT Kurukshetra<br>136119 kurukshetra<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
                    
                    <?php
                    
                    if(isset($_POST['submit'])){
                        echo "good";
                        $name=mysqli_real_escape_string($conn,$_POST['name']);
                        $email=mysqli_real_escape_string($conn,$_POST['email']);
                        $website=mysqli_real_escape_string($conn,$_POST['website']);
                        $comment=mysqli_real_escape_string($conn,$_POST['comment']);
                        
                        $to = "mahawarrahul51@gmail.com";
                        $header="$name<$email>";
                        $subject="Message from $name through Trendy-Blog";
                        
                        $message="Name: $name\n\nEmail: $email\n\nWebsite: $website\n\nMessage:\n$comment";
                        
                        if(mail($to, $subject, $message, $header)){
                            $msg="Your message has been sent successfully";
                        }
                        else{
                            $error="Message has not been sent";
                        }
                    }
                    
                    ?>
                    <div class="form">
                        <div class="row">
                            <div class="col-md-12 ">
                               <h3 class="txt-primary">Contact Form</h3><hr>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="fullname">Full Name:</label>
                                        <?php
                                        if(isset($msg)){
                                            echo " <span class='pull-right' style='color:green' >$msg</span>";
                                        }
                                        else if(isset($error)){
                                            echo " <span class='pull-right' style='color:red' >$error</span>";
                                        }
                                        ?>
                                        <input type="text" placeholder="Your Full Name" class="form-control" id="fullname" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" placeholder="Email" name="email" class="form-control" id="fullname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="website">Website:</label>
                                        <input type="text" placeholder="Website" name="website" class="form-control" id="fullname">
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Message:</label>
                                        <textarea name="comment" class="form-control" placeholder="Your message should be here!" id="message" cols="30" rows="10" required></textarea>
                                    </div>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <?php require_once("inc/sidebar.php");?>
                </div>
            </div>
        </div>
    </section>
    <?php require_once("inc/footer.php");?>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
  </html>