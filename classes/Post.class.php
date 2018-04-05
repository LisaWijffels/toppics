<?php

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

        /**
         * Get the value of post_id
         */ 
        public function getPost_id()
        {
                return $this->post_id;
        }

        /**
         * Set the value of post_id
         *
         * @return  self
         */ 
        public function setPost_id($post_id)
        {
                $this->post_id = $post_id;

                return $this;
        }

        /**
         * Get the value of post_desc
         */ 
        public function getPost_desc()
        {
                return $this->post_desc;
        }

        /**
         * Set the value of post_desc
         *
         * @return  self
         */ 
        public function setPost_desc($post_desc)
        {
                $this->post_desc = $post_desc;

                return $this;
        }

        /**
         * Get the value of post_image
         */ 
        public function getPost_image()
        {
                return $this->post_image;
        }

        /**
         * Set the value of post_image
         *
         * @return  self
         */ 
        public function setPost_image($post_image)
        {
                $this->post_image = $post_image;

                return $this;
        }

        /**
         * Get the value of post_likes
         */ 
        public function getPost_likes()
        {
                return $this->post_likes;
        }

        /**
         * Set the value of post_likes
         *
         * @return  self
         */ 
        public function setPost_likes($post_likes)
        {
                $this->post_likes = $post_likes;

                return $this;
        }

        /**
         * Get the value of post_user_id
         */ 
        public function getPost_user_id()
        {
                return $this->post_user_id;
        }

        /**
         * Set the value of post_user_id
         *
         * @return  self
         */ 
        public function setPost_user_id($post_user_id)
        {
                $this->post_user_id = $post_user_id;

                return $this;
        }

        /**
         * Get the value of post_date
         */ 
        public function getPost_date()
        {
                return $this->post_date;
        }

        /**
         * Set the value of post_date
         *
         * @return  self
         */ 
        public function setPost_date($post_date)
        {
                $this->post_date = $post_date;

                return $this;
        }

        public function Save() {
            $statement = $this->db->prepare("insert into posts (post_id, post_desc, post_image, post_likes, post_user_id, post_date) values (:post_id, :post_desc, :post_image, :post_likes, :post_user_id, :post_date)");
            $statement->bindValue(":post_id", $this->getPost_id());
            $statement->bindValue(":post_desc", $this->getPost_desc());
            $statement->bindValue(":post_image", $this->getPost_image());
            $statement->bindValue(":post_likes", $this->getPost_likes());
            $statement->bindValue(":post_user_id", $this->getPost_user_id());
            $statement->bindValue(":post_date", $this->getPost_date());
            //dat gaat die query in db uitvoeren en true terug sturen als gelukt en false als niet gelukt.
            return $statement->execute();



        }
    }

?>