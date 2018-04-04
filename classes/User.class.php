<?php 
    class User {
        private $email;
        private $password;
        private $username;
        private $db;

        public function __construct($db){
            $this->db = $db;
        }

         
        public function getUsername()
        {
                return $this->username;
        }

    
        public function setUsername($username)
        {
            if( empty($username) ){
                throw new Exception("Username cannot be empty");
            }
            
            $this->username = $username;
            return $this;
    
            
        }
        
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
            
            $stm = $this->db->prepare("INSERT INTO users (username, email, password) values (:username, :email, :password)");
            
            $options = [
                'cost' => 12,
            ];
        
            $hash = password_hash($this->password, PASSWORD_DEFAULT, $options);
            $stm->bindParam(":username", $this->username);
            $stm->bindParam(":email", $this->email);
            $stm->bindParam(":password", $hash);
            
            //execute
            $result = $stm->execute();
            
            //antwoord geven
            return $result;
        }
        
        public function login(){
            session_start();
            $_SESSION['username'] = $this->username;
            header("Location: index.php");
        }

        public function canIlogin(){
            $stm = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $result = $stm->execute();
            if($result){
                $user = $stm->fetch(PDO::FETCH_ASSOC);
                if(password_verify($this->password, $user['password']) ){
                    return true;
                    echo "Login succes";
                } else {
                    return false;
                    echo "login failed";
                }
            }else{
                return true;
                echo "No rowcount";
            }
        }


        
    }


?>