<?php 

 if(!isset($_SESSION['user'])){
      
     header("Location: ".url('/login.php')); 
     exit();
 }


?>