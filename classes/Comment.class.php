<?php

include_once('Db.class.php');

class Comment {
        private $comment;
        private $postID;
        private $db;
        private $user_id;

        public function getComment()
        {
                return $this->comment;
        }

        public function setComment($comment)
        {
                $this->comment = $comment;

                return $this;
        }

        public function getPostID()
        {
                return $this->postID;
        }

        public function setPostId($postID)
        {
                $this->postID = $postID;

                return $this;
        }

        public function getUser_id()
        {
                return $this->user_id;
        }

        public function setUser_id($user_id)
        {
            $db = Db::getInstance();
            $stm = $db->prepare("SELECT id, username FROM users WHERE username = :username");
            $stm->bindValue(":username", $user_id);
            $stm->execute();
            $user = $stm->fetch(PDO::FETCH_ASSOC);

            $this->user_id = $user['id'];

            return $this;
        }

        public function Save(){
            $db = Db::getInstance();
            $statement = $db->prepare("INSERT INTO comments (user_id, post_id, text) VALUES (:user_id, :post_id, :text)");
            $statement->bindValue(":user_id", $this->user_id);
            $statement->bindValue(":post_id", $this->postID);
            $statement->bindValue(":text", $this->comment);

           return $statement->execute();
        }

        public static function getAll($postId){
            $db = Db::getInstance();
            $statement = $db->prepare("SELECT text FROM comments WHERE post_id = :postID");
            $statement->bindValue(":postID", $postId );
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)){
                throw new Exception("There are no comments yet. Write one!");
            } else {
                return($result);
            }
            
        }


        
    } 

?>