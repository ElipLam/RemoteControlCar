<?php
	require_once 'lib/adminuser.php';
	
    $username = "";
    
    $password = "";

    $repassword = "";
	
	$error = "";
    
    if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        
    }
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }

    if(isset($_POST['repassword'])){
        
        $repassword = $_POST['repassword'];
        
    }
    
    $userObject = new AdminUser();
	
        // Registration
    
    if(!empty($username) && !empty($password) && !empty($repassword)){

        if (!($password == $repassword))
        {
            $error = "Password did not match!";
        }
        else {
            $hashed_password = $password;
        
            $result = $userObject->createNewRegisterUser($username, $hashed_password);
            
            if ($result) {
             
                header("location: index.php");
                
            }else {
                $error = $_SESSION['error'];
            }
        }
    }
    else {
        $error = "Please enter all field!";
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <link rel="stylesheet" type="text/css" href="css/home.css" />
			<meta charset="UTF-8">
    </head>
    <body>
        <title>Signup</title>
        <form method = "POST" action="" >
                <h1>Signup</h1>
                    <input name="username" placeholder="Username" type="text" required="">
                    <input name="password" placeholder="Password" type="password" required="">
                    <input name="repassword" placeholder="Repassword" type="password" required="">
                    <button name="btnsignup">Sign-Up</button>
                    <div class="error-rev"><?php echo $error; ?></div>
            </form>
    </body> 
</html>
