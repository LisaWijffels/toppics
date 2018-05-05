<?php

include_once('Db.class.php');

class Comment {
        private $comment;
        private $postID;
        private $db;

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

        public function Save()
        {
            $db = Db::getInstance();
            $statement = $db->prepare("insert into comments (user_id, post_id, text) values (:user_id, :post_id, :text)");
            $statement->bindValue(":user_id", 1);
            $statement->bindValue(":post_id", $this->getPostID());
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