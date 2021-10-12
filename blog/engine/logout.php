<?php 
   include('../connect/db.php');
   session_start();
   unset($_SESSION['id']);
   unset($_SESSION['images']);
   unset($_SESSION['username']);
   unset($_SESSION['email']);
   unset($_SESSION['channel']);
   unset($_SESSION['desc']);
   session_destroy();
   header('location: ../../login.php');
   echo 'please wait...';

?>