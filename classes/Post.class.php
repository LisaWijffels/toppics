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

                public function getPost_id()
                {
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT post_id FROM posts WHERE username = :username");
                        $stm->bindValue(":username", $post_user);
                        $stm->execute();
                        $user = $stm->fetch(PDO::FETCH_ASSOC);

                        $this->post_user_id = $user['id'];
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
                        function random_string($length) {

                                $key = '';
                                $keys = array_merge(range(0, 9), range('a', 'z'));
                            
                                for ($i = 0; $i < $length; $i++) {
                                    $key .= $keys[array_rand($keys)];
                                }
                            
                                return $key;
                        }
                            
                        $save_path= dirname(__FILE__) . '\..\post_images\ ';
                        $myname = random_string(10).$post_image['name'];
                        move_uploaded_file($post_image['tmp_name'], $save_path.$myname);

                        $this->post_image = $myname;

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


                public function setPost_user_id($post_user)
                {
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT id, username FROM users WHERE username = :username");
                        $stm->bindValue(":username", $post_user);
                        $stm->execute();
                        $user = $stm->fetch(PDO::FETCH_ASSOC);

                        $this->post_user_id = $user['id'];

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
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("INSERT INTO posts (post_desc, post_image, post_user_id, post_date) VALUES (:post_desc, :post_image, :post_user_id, now())");
                        $stm->bindValue(":post_desc", $this->post_desc);
                        $stm->bindValue(":post_image", $this->post_image);
                        $stm->bindValue(":post_user_id", $this->post_user_id);
                        $result = $stm->execute();
                        $id = $conn->lastInsertId();
                        return $id;
                        

                }

                public function postDetails(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM posts WHERE post_id = :post_id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        return $result;
                }

                public function postComments(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM comments, users WHERE post_id = :post_id AND comments.user_id = users.id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        return $stm->fetchAll(PDO::FETCH_ASSOC);
                        
                }

                public static function ShowPosts(){

                        $conn = Db::getInstance();
                        $statement = $conn->prepare("SELECT posts.post_id, post_desc, post_image, post_likes, post_date, username, tag_name FROM posts, users, tags 
                                        WHERE posts.post_user_id = users.id AND tags.post_id = posts.post_id ORDER BY post_date desc limit 20");
                        $statement->execute();

                        return $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                public static function searchPosts($search){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM posts, tags WHERE tags.post_id = posts.post_id");
                        
                        $stm->execute();
                        $posts = $stm->fetchAll(PDO::FETCH_ASSOC);

                        $foundPosts = [];
                        foreach($posts as $p){
                                if(strpos(strtolower($p['post_desc']), strtolower($search)) !== false || strpos(strtolower($p['tag_name']), strtolower($search)) !== false){
                                    $foundPosts[] = $p;
                                }

                                
                        }

                        return $foundPosts;
                }

                
        }

?>