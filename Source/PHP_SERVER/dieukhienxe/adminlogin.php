<?php
	require_once 'lib/adminuser.php';
	
    $username = "";
    
    $password = "";
	
	$error = "";
    
    if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        
    }
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    
    
    
    $userObject = new AdminUser();
    
    
    // Login
    
    if(!empty($username) && !empty($password)){
        
        $hashed_password = $password;
        
        $result = $userObject->loginUsers($username, $hashed_password);
        
        if ($result) {
         $_SESSION['login_user'] = $username;
         
         header("location: index.php");
		}else {
         $error = "Your Login Name or Password is invalid";
      }
    }

?>

<!DOCTYPE html>
<html>
    <head>
            <link rel="stylesheet" type="text/css" href="css/home.css" />
			<meta charset="UTF-8">
			<link rel="icon" type="image/png" href="images/rooticon.ico"/>
    </head>
    <body>
        <title>HOME</title>
        <form method = "POST" action="" >
                <h1>Login</h1>
                    <input name="username" placeholder="Username" type="text" required="">
                    <input name="password" placeholder="Password" type="password" required="">
                    <button name ="btnlogin">Login with Admin</button>
                    <br>
                    <div class="error-rev"><?php echo $error; ?></div>
                    <br>
                    <div class="href_div"><a class="edit_href" href="t-rex-runner/index.html" target="_self">Forget password</a></div>                   				
                    <div class="href_div"><a class="edit_href" href="adminregistration.php" target="_self">Create account</a></div>                                       
        </form>
    </body> 
</html>

