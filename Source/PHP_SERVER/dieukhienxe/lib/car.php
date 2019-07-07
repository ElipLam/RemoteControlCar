<?php
    
    include_once 'db_connect.php';
    
    class Car{
        
        private $db;
        
        private $db_table = "cars";
        
        public function __construct(){
            $this->db = new DbConnect();
        }
        
        public function isCarnameExist($carname){
            
            $query = "select * from ".$this->db_table." where name = '$carname'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){

                mysqli_close($this->db->getDb());

                return true;
            }
            
            return false;
            
        }
        
        public function createNewRegisterCar($name, $state){

            $json = array();
            
            $isExisting = $this->isCarnameExist($name);
            
            if($isExisting){
                
                $json['message'] = "Error in registering. Probably the carname already exists";
            }
            
            else{

                if (($state > 4) || ($state < 0)){

                    $json['message'] = "Error. State must be between 0 and 4";

                }
                else {

                    $query = "insert into ".$this->db_table." (name, state) values ('$name', '$state')";
                
                    $inserted = mysqli_query($this->db->getDb(), $query);
                
                    if($inserted == 1){
                    
                        $json['message'] = "Successfully registered the car";
                    
                    }
                    else{

                        $json['message'] = "Error in registering. Probably the car name already exists";
                    
                    }
                
                    mysqli_close($this->db->getDb()); 
                }       
            }
            
            return $json;
            
        }
        

        public function deleteCar($id){

            $json = array();

            $query = "delete from ".$this->db_table." where id = '$id'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if($result){ 

                $json['message'] = "Car deleted successfully";

            }
            else {

                $json['message'] = "Error deleting Car";

            }
            
            mysqli_close($this->db->getDb());

            return $json;
        }

        public function updateCar($id, $state)
        {
            $json = array();

            if (($state > 4) || ($state < 0)) {

                $json['message'] = "Error. State must be between 0 and 4";
            }

            else {

                $query = "update ".$this->db_table." set state = '$state' where id = '$id'";

                $result = mysqli_query($this->db->getDb(), $query);
    
                if ($result) {
    
                    $json['message'] = "Successfully change";
    
                }
                else {
    
                    $json['message'] = "Error editing car";
    
                }
            }

            mysqli_close($this->db->getDb());

            return $json;

        }

    }
?>