<?php 

include_once("Db.class.php");

    class Follow {

        private $loggeduser;
        private $username;
        private $follow_id;

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

        public function CheckFollower()
        {
            $conn = Db::getInstance();
            $stmt = $conn->prepare("SELECT * FROM follow WHERE follower_id = :loggeduser");
            $stmt->bindValue(":loggeduser", $this->loggeduser);
            $stmt->execute();

            $rows = $stmt->rowCount();

                if($rows > 0 ){
                    throw new Exception("you don't follow anyone yet");
                }
        }

        public function ShowFollowedPosts($loggeduser){

            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT users_id FROM follow WHERE follower_id = :loggeduser");
            $statement->bindValue(":loggeduser", $this->loggeduser);
            $statement->execute();
            $ID = $statement->fetchAll();

            foreach($ID as $id){
                        
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM posts, users, follow WHERE NOT post_user_id = :loggeduser AND posts.post_user_id = users.id 
            AND follower_id = :loggeduser AND users_id = :id AND users.id in (follower_id, users_id)
            ORDER BY post_date desc limit 5");
            $statement->bindValue(":loggeduser", $this->loggeduser);
            $statement->bindValue(":id", $id['users_id']);
            $statement->execute();
            }

            return $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LoadMoreFollowPosts($lastId, $loggeduser){

            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT users_id FROM follow WHERE follower_id = :loggeduser");
            $statement->bindValue(":loggeduser", $this->loggeduser);
            $statement->execute();
            $ID = $statement->fetchAll();

            foreach($ID as $id){

            $conn = Db::getInstance();
            $stmt = $conn->prepare("SELECT * FROM posts, users, follow, locations 
            WHERE NOT post_user_id = :loggeduser 
            AND posts.post_user_id = users.id 
            AND follower_id = :loggeduser 
            AND users_id = :id 
            AND users.id in (follower_id, users_id) 
            AND posts.post_id < :lastId 
            ORDER BY post_date desc limit 5");
            $stmt->bindValue(":lastId", $lastId);
            $stmt->bindValue(":loggeduser", $this->loggeduser);
            $stmt->bindValue(":id", $id['users_id']);
            $stmt->execute();
            $followposts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $foundPosts = [];
                foreach($followposts as $f){
                            
                    $foundPosts[$f['post_id']] = $f;
                            
                }

            }

            return $followposts;
        }


       
    }     
?>