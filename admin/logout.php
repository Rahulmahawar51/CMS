<?php
session_start();
echo "<script>window.top.location='login.php'</script>";
session_destroy();
?>