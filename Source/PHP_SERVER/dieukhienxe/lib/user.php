<?php
    
    include_once 'db_connect.php';
    
    class User{
        
        private $db;
        
        private $db_table = "users";
        
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
                        $json['username'] = $username;
                    
                    }
                    else{

                        $json['success'] = 0;
                        $json['message'] = "Error in registering. Probably the username already exists";
                    
                    }
                
                    mysqli_close($this->db->getDb());
                }
            }
            
            return $json;
            
        }
        
        public function loginUsers($username, $password){
            
            $json = array();
            
            $canUserLogin = $this->isLoginExist($username, $password);
            
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['message'] = "Successfully logged in";
                $json['username'] = $username;
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }

        public function deleteUser($username){

            $json = array();

            $query = "delete from ".$this->db_table." where user_name = '$username'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if($result){ 

                $json['message'] = "User deleted successfully";

            }
            else {

                $json['error'] = "Error deleting User";

            }
            
            mysqli_close($this->db->getDb());

            return $json;

        }

        public function updateUser($id, $password)
        {
            $json = array();

            $query = "update ".$this->db_table." set user_password = '$password' where id = '$id'";

            $result = mysqli_query($this->db->getDb(), $query);

            if ($result) {
                $json['success'] = 1;

                $json['message'] = "Successfully change";
            }
            else {
                $json['success'] = 0;

                $json['message'] = "Error editing user";
            }

            mysqli_close($this->db->getDb());

            return $json;

        }

        public function changePassword($username, $currentpassword, $newpassword) 
        {
            $json = array();

            $query = "select * from ".$this->db_table." where user_name = '$username'AND user_password = '$currentpassword' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);

            if (mysqli_num_rows($result) > 0) {     //if user exist

                $row = mysqli_fetch_assoc($result);

                $id = $row["id"];

                $query = "update ".$this->db_table." set user_password = '$newpassword' where id = '$id'";

                $result = mysqli_query($this->db->getDb(), $query);

                if ($result) {

                    $json['success'] = 1;

                    $json['message'] = "Successfully change";
                }
                else {
                    $json['success'] = 0;

                    $json['message'] = "Error when change password";
                }

            }
            else {  //user not exist

                $json['success'] = 0;

                $json['message'] = "Password incorrect";

            }
            
            mysqli_free_result($result);
            mysqli_close($this->db->getDb());

            return $json;

        }

    }
?>