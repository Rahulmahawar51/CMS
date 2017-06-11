<?php require_once('inc/top.php'); ?>
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