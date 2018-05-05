<?php

    class Comment {
        private $comment;
        private $postID;
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

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
            $statement = $this->db->prepare("insert into comments (user_id, post_id, text) values (:user_id, :post_id, :text)");
            $statement->bindValue(":user_id", 1);
            $statement->bindValue(":post_id", $this->getPostID());
            $statement->bindValue(":text", $this->comment);

           return $statement->execute();
        }

        public function getAll()
        {
            $statement = $this->db->prepare("select text from comments where post_id = :postID");
            $statement->bindValue(":postID", $this->getPostID());
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return($result);
        }

    } 

?>