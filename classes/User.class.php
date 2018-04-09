<?php 
    class User {
        private $email;
        private $password;
        private $username;
        private $db;
        private $user_picture;
        private $usertext;

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

        public function getUser_picture()
        {
                return $this->user_picture;
        }

         
        public function setUser_picture($user_picture)
        {
                $this->user_picture = $user_picture;

                return $this;
        }

        
        public function getUsertext()
        {
                return $this->usertext;
        }

        
        public function setUsertext($usertext)
        {
                $this->usertext = $usertext;

                return $this;
        }

        public function canIregister(){
            $stm = $this->db->prepare("SELECT * FROM users WHERE (username=:username or email=:email)");
            $stm->bindParam(":username", $this->username);
            $stm->bindParam(":email", $this->email);
            $result = $stm->execute();
            $user = $stm->fetch(PDO::FETCH_ASSOC);
            
            if($user['username'] == $this->username){
                throw new Exception('Username already exists. Please choose a different username.');
            } else if($this->email == $user['email']) {
                throw new Exception('Email already exists. Please choose a different username.');
            }
        }
        
        public function register($hash){
            
            $stm = $this->db->prepare("INSERT INTO users (username, email, password) values (:username, :email, :password)");
            
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

        public function canIlogin($pw){
            $stm = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $result = $stm->execute();
            $user = $stm->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($user)){
                if(password_verify($pw, $user['password']) ){
                    return true;
                    
                } else {
                    throw new Exception("Password is invalid. Please try again.");
                }

            } else {
                throw new Exception("Username is invalid. Please try again.");
            }
        }
        

        public function editText(){
            $stm = $this->db->prepare("UPDATE users SET user_text = :user_text WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $stm->bindParam(":user_text", $this->usertext);
            $result = $stm->execute();

            
        }

        public function editEmail(){
            $stm = $this->db->prepare("UPDATE users SET email = :email WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $stm->bindParam(":email", $this->email);
            $result = $stm->execute();

            
        }

        public function getValues(){
            
            $stm = $this->db->prepare("SELECT * from users WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        }

        public function editPicture(){
            function random_string($length) {
                $key = '';
                $keys = array_merge(range(0, 9), range('a', 'z'));
            
                for ($i = 0; $i < $length; $i++) {
                    $key .= $keys[array_rand($keys)];
                }
            
                return $key;
            }
            
            

            $save_path= dirname(__FILE__) . '\..\user_images\ ';
            $myname = random_string(10).$this->user_picture['name'];
            move_uploaded_file($this->user_picture['tmp_name'], $save_path.$myname);

            $stm = $this->db->prepare("UPDATE users SET user_picture = :user_picture WHERE username = :username");
            $stm->bindParam(":username", $this->username);
            $stm->bindParam(":user_picture", $myname);
            $stm->execute();

        

            
        }


        
    }


?>