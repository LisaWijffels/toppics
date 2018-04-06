<?php

include_once('Db.class.php');

    class Post {
        private $post_id;
        private $post_desc;
        private $post_image;
        private $post_likes;
        private $post_user_id;
        private $post_date;
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }
 
        public function getPost_id()
        {
                return $this->post_id;
        }

        public function setPost_id($post_id)
        {
                $this->post_id = $post_id;

                return $this;
        }

        public function getPost_desc()
        {
                return $this->post_desc;
        }

        public function setPost_desc($post_desc)
        {
                $this->post_desc = $post_desc;

                return $this;
        }

        public function getPost_image()
        {
                return $this->post_image;
        }

      
        public function setPost_image($post_image)
        {
                $this->post_image = $post_image;

                return $this;
        }

       
        public function getPost_likes()
        {
                return $this->post_likes;
        }

       
        public function setPost_likes($post_likes)
        {
                $this->post_likes = $post_likes;

                return $this;
        }

        public function getPost_user_id()
        {
                return $this->post_user_id;
        }


        public function setPost_user_id($post_user_id)
        {
                $this->post_user_id = $post_user_id;

                return $this;
        }

        public function getPost_date()
        {
                return $this->post_date;
        }

        public function setPost_date($post_date)
        {
                $this->post_date = $post_date;

                return $this;
        }

        public function Save() {
            $stm = $this->db->prepare("INSERT INTO posts (post_desc) VALUES (:post_desc)");
            $stm->bindValue(":post_desc", $this->post_desc);
            $result = $stm->execute();
            //dat gaat die query in db uitvoeren en true terug sturen als gelukt en false als niet gelukt.
            return $result;

        }

        public static function ShowPosts()
        {
             $conn = Db::getInstance();
             $statement = $conn->prepare("select * from posts ORDER BY post_date desc limit 20");
             $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>