<?php
    
    require_once 'lib/user.php';
    
    $username = "";
    
    $currentpassword = "";

    $newpassword = "";
    
    if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        
    }
    
    if(isset($_POST['currentpassword'])){
        
        $currentpassword = $_POST['currentpassword'];
        
    }
    
    if(isset($_POST['newpassword'])){
        
        $newpassword = $_POST['newpassword'];
        
    }
    
    $userObject = new User();
    
    
    // Change password
    
    if(!empty($username) && !empty($currentpassword) && !empty($newpassword)){
        
        $json_array = $userObject->changePassword($username, $currentpassword, $newpassword);
        
        echo json_encode($json_array);
    }
?>