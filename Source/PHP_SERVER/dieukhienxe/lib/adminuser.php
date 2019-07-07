<?php
    
    include_once 'db_connect.php';
    
	session_start();
	
    class AdminUser{
        
        private $db;
        
        private $db_table = "admin_user";
        
        public function __construct(){
            $this->db = new DbConnect();
        }
        
        public function isLoginExist($username, $password){
            
            $query = "select * from ".$this->db_table." where user_name = '$username' AND user_password = '$password' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());

                return true;
            }
            
            mysqli_close($this->db->getDb());

            return false;
        }
        
        public function isUsernameExist($username){
            
            $query = "select * from ".$this->db_table." where user_name = '$username'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){

                mysqli_close($this->db->getDb());

                return true;
            }
            
            return false;
            
        }
        
        public function isValidEmail($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        
        public function createNewRegisterUser($username, $password){
            
            $isExisting = $this->isUsernameExist($username);
            
            if($isExisting){
                
                $json['success'] = 0;
                $json['message'] = "Error in registering. Probably the username already exists";
				$_SESSION['error'] = "Error in registering. The username already exists";
				return false;
            }
            
            else{
                
                $isValid = 1;//$this->isValidEmail($email);
                
                if($isValid)
                {
                    $query = "insert into ".$this->db_table." (user_name, user_password) values ('$username', '$password')";
                
                    $inserted = mysqli_query($this->db->getDb(), $query);
                
                    if($inserted == 1){
                    
                        $json['success'] = 1;
                        $json['message'] = "Successfully registered the user";
						return true;
                    }
                    else{

                        $json['success'] = 0;
                        $json['message'] = "Error in registering. Probably the username already exists";
						$_SESSION['error'] = "Error in registering. Probably the username already exists";
						return false;
                    }
                
                    mysqli_close($this->db->getDb());
                }
            }
            
            
        }
        
        public function loginUsers($username, $password){
            
            $json = array();
            
            $canUserLogin = $this->isLoginExist($username, $password);
            
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['message'] = "Successfully logged in";
				return true;
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
				return false;
            }
        }

        
    }
?>