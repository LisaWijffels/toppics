<?php 

include_once("Db.class.php");

    class Follow {

        private $loggeduser;
        private $username;

        public function getLoggeduser()
        {
                return $this->loggeduser;
        }


        public function setLoggeduser($loggeduser)
        {
            $db = Db::getInstance();
            $stmt = $db->prepare("SELECT id, username FROM users WHERE username = :username");
            $stmt->bindValue(":username", $loggeduser);
            $stmt->execute();
            $loggeduserID = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->loggeduser = $loggeduserID['id'];

            return $this;
        }

        public function getUsername()
        {
                return $this->username;
        }

        
        public function setUsername($username)
        {
            $db = Db::getInstance();
            $stmt = $db->prepare("SELECT id, username FROM users WHERE username = :username");
            $stmt->bindValue(":username", $username);
            $stmt->execute();
            $usernameID = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->username = $usernameID['id'];

            return $this;
        }
        
        public function FollowFriends($username)
        {
            $conn = Db::getInstance();
            $stmt = $conn->prepare("INSERT INTO follow (users_id, follower_id) VALUES (:users_id, :follower_id)"); 
            $stmt->bindValue(":users_id", $username);
            $stmt->bindValue(":follower_id", $this->loggeduser);
            $result = $stmt->execute();
            return $result;
            
        }

        public function CheckFollow()
        {
            $conn = Db::getInstance();
            $stmt = $conn->prepare("SELECT * FROM follow WHERE users_id = :users_id AND follower_id = :follower_id");
            $stmt->bindValue(":users_id", $this->username);
            $stmt->bindValue(":follower_id", $this->loggeduser);
            $stmt->execute();
            
            $number_of_rows = $stmt->rowCount();

            if($number_of_rows > 0 ){
                throw new Exception("Already following this person");
    
            }
        }

        
    }     
?>