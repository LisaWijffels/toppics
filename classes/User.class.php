<?php 
    class User {
        private $email;
        private $password;
        
        public function getPassword(){
    
        }

        public function setPassword(){

        }

        public function getEmail(){

        }

        public function setEmail($email){
            if( empty($email) ){
                throw new Exception("Email cannot be empty");
            }
            
            $this->email = $email;
            return $this;
    
            //todo: valid email? -> filter_var();
        }
        
        public function register(){
            //connectie
            $conn = new PDO('mysql:host=localhost:3307; dbname=netflix', 'root', '');
            
            //query
            $stm = $conn->prepare("INSERT INTO users (email, password) values (:email, :password)");
            
            $options = [
                'cost' => 12,
            ];
        
            $hash = password_hash($this->password, PASSWORD_DEFAULT, $options);
            $stm->bindParam(":email", $this->email);
            $stm->bindParam(":password", $hash);
            
            //execute
            $result = $stm->execute();
            
            //antwoord geven
            return $result;
        }
        
        public function login(){
            session_start();
            $_SESSION['username'] = $this->email;
            header("Location: index.php");
        }

    }


?>