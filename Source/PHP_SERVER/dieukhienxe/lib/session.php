<?php
   include('lib/db_connect.php');

   session_start();

   $db = new DbConnect();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db->getDb(),"select user_name from admin_user where user_name = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['user_name'];
   
   if(!isset($_SESSION['login_user'])){
      header("Location: adminlogin.php");
      die();
   }
?>