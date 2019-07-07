<?php
    
    require_once 'lib/user.php';
    
    $username = "";
    
    $password = "";
    
    if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        
    }
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    
    
    
    $userObject = new User();
    
    
    // Login
    
    if(!empty($username) && !empty($password)){
        
        $hashed_password = $password;
        
        $json_array = $userObject->loginUsers($username, $hashed_password);
        
        echo json_encode($json_array);
    }
?>