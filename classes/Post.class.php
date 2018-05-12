<?php

include_once('Db.class.php');

        class Post {
                private $post_id;
                private $post_desc;
                private $post_image;
                private $post_likes;
                private $post_user_id;
                private $post_date;
                private $post_user;
                private $db;
                private $location;
                private $loggeduser;

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

                public function getPost_user()
                {
                                return $this->post_user;
                }

                
                public function setPost_user($post_user)
                {
                                $this->post_user = $post_user;

                                return $this;
                }

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

                        
                public function setPost_image($post_image){
                        function random_string($length) {

                                $key = '';
                                $keys = array_merge(range(0, 9), range('a', 'z'));
                            
                                for ($i = 0; $i < $length; $i++) {
                                    $key .= $keys[array_rand($keys)];
                                }
                            
                                return $key;
                        }

                        $myname = random_string(10).$post_image['name'];
                        $thumb_size = 400;
                        $img = file_get_contents( $post_image['tmp_name'] );
                        $image = imagecreatefromstring( $img );

                        $width = imagesx($image);
                        $height = imagesy($image);

                        $original_aspect = $width / $height;
                        
                        if ( $original_aspect >= 1 ){
                                // If image is wider than thumbnail (in aspect ratio sense)
                                $new_height = $thumb_size;
                                $new_width = $width / ($height / $thumb_size);
                        }else{
                                // If the thumbnail is wider than the image
                                $new_width = $thumb_size;
                                $new_height = $height / ($width / $thumb_size);
                        }

                        $thumb = imagecreatetruecolor( $thumb_size, $thumb_size );

                        // Resize and crop
                        imagecopyresampled($thumb,
                                        $image,
                                        0 - ($new_width - $thumb_size) / 2, // Center the image horizontally
                                        0 - ($new_height - $thumb_size) / 2, // Center the image vertically
                                        0, 0,
                                        $new_width, $new_height,
                                        $width, $height);
                        imagejpeg($thumb, $myname, 80);

                        if(!defined('__ROOT__')){
                                define('__ROOT__', dirname(dirname(__FILE__)));
                        }
                            
                        $save_path= __ROOT__.'/post_images/ ';
                        rename($myname, $save_path . $myname);
                        
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

                public function getPost_user_id(){
                        return $this->post_user_id;
                }


                public function setPost_user_id($post_user){
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

                public function setPost_date($post_date){
                        $this->post_date = $post_date;

                        return $this;
                }

                public function getLocation()
                {
                        return $this->location;
                }

                public function SaveLocation($location)
                {
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("INSERT INTO locations (location_name, location_post_id) VALUES (:post_location, :post_id +1)");
                        $stm->bindValue(":post_location", $location);
                        $stm->bindValue(":post_id", $this->post_id);
                        $result = $stm->execute();
        
                        return $result;
                }

                public function Save() {
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("INSERT INTO posts (post_desc, post_image, post_user_id, post_date) VALUES (:post_desc, :post_image, :post_user_id, now())");
                        $stm->bindValue(":post_desc", $this->post_desc);
                        $stm->bindValue(":post_image", $this->post_image);
                        $stm->bindValue(":post_user_id", $this->post_user_id);
                        $result = $stm->execute();
                        $this->post_id = $conn->lastInsertId();
                        return $result;
                }

                public function saveTags($post_tags){
                        $tagsNoSpace = str_replace(' ', '', $post_tags);
                        $tags = explode("," ,$tagsNoSpace);

                        $conn = Db::getInstance();

                        foreach ($tags as $t){
                                $stm = $conn->prepare("INSERT INTO tags (post_id_link, tag_name) VALUES (:post_id, :tag_name)");
                                $stm->bindValue(":post_id", $this->post_id);
                                $stm->bindValue(":tag_name", $t);
                                $result = $stm->execute();
                                
                        }

                        return $tags;
                        
                }

                public function postDetails(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT `post_id`, `post_desc`, `post_image`, `post_likes`, `post_user_id`, `post_date`, `username`, `id` FROM posts, users WHERE posts.post_id = :post_id AND posts.post_user_id = users.id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        return $result;
                }

                public function postTags(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT `post_id`, `post_id_link`, `tag_name`, `id` FROM posts, tags WHERE post_id = :post_id AND tags.post_id_link = posts.post_id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        return $stm->fetchAll(PDO::FETCH_ASSOC);
                }

                public function postLocation(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT `post_id`, `location_post_id`, `location_name`, `id` FROM posts, locations WHERE post_id = :post_id AND locations.location_post_id = posts.post_id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        return $stm->fetchAll(PDO::FETCH_ASSOC);
                }

                public function postComments(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM comments, users WHERE post_id = :post_id AND comments.user_id = users.id");
                        $stm->bindValue(":post_id", $this->post_id);
                        $stm->execute();
                        return $stm->fetchAll(PDO::FETCH_ASSOC);
                        
                }

                public function ShowPosts(){

                        $conn = Db::getInstance();
                        $statement = $conn->prepare("SELECT * FROM posts, users WHERE NOT post_user_id = :loggeduser AND posts.post_user_id = users.id  
                        AND posts.active = 1 ORDER BY post_date desc limit 20");
                        $statement->bindValue(":loggeduser", $this->loggeduser);
                        $statement->execute();

                        return $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                public function LoadMore($lastId){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM posts, users WHERE NOT post_user_id = :loggeduser AND posts.post_user_id = users.id 
                        AND posts.active = 1 AND posts.post_id < :lastId ORDER BY post_date desc limit 20");
                        $stm->bindValue(":lastId", $lastId);
                        $stm->bindValue(":loggeduser", $this->loggeduser);
                        $stm->execute();

                        return $stm->fetchAll(PDO::FETCH_ASSOC);
                }

                public static function searchPosts($search){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("SELECT * FROM posts, users WHERE posts.post_user_id = users.id AND posts.active = 1;");
                        $stm->execute();
                        $posts = $stm->fetchAll();
                        
                        $stb = $conn->prepare("SELECT * FROM posts, tags, users WHERE posts.post_id = tags.post_id_link AND posts.post_user_id = users.id AND posts.active = 1");
                        $stb->execute();
                        $tags = $stb->fetchAll();

                        $stl = $conn->prepare("SELECT * FROM posts, users, locations WHERE posts.post_id = locations.location_post_id AND posts.post_user_id = users.id AND posts.active = 1");
                        $stl->execute();
                        $locations = $stl->fetchAll();

                        $foundPosts = [];
                        foreach($posts as $p){
                                if(strpos(strtolower($p['post_desc']), strtolower($search)) !== false){
                                        $foundPosts[$p['post_id']] = $p;
                                }
                        }
                        foreach($tags as $t){
                                if(strpos(strtolower($t['tag_name']), strtolower($search)) !== false){
                                        $foundPosts[$t['post_id']] = $t;
                                }

                        }

                        foreach($locations as $l){
                                if(strpos(strtolower($l['location_name']), strtolower($search)) !== false){
                                        $foundPosts[$l['post_id']] = $l;
                                }

                        }

                        

                        return $foundPosts;
                }

                public function editDesc(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("UPDATE posts SET post_desc = :post_desc WHERE post_id = :post_id");
                        $stm->bindParam(":post_id", $this->post_id);
                        $stm->bindParam(":post_desc", $this->post_desc);
                        $result = $stm->execute();
                        return $result;
                }

                public function deletePost(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("DELETE FROM posts WHERE post_id = :id");
                        $stm->bindValue(":id", $this->post_id);
                        $result = $stm->execute();

                        return $result;
                }

                public function hidePost(){
                        $conn = Db::getInstance();
                        $stm = $conn->prepare("UPDATE posts SET active = 0 WHERE post_id = :id");
                        $stm->bindValue(":id", $this->post_id);
                        $result = $stm->execute();

                        return $result;
                }

                public function CheckOwnPosts()
                {
                        $conn = Db::getInstance();
                        $stmt = $conn->prepare("SELECT * FROM posts WHERE post_user_id = :loggeduser");
                        $stmt->bindValue(":loggeduser", $this->loggeduser);
                        $stmt->execute();

                        $rows = $stmt->rowCount();

                        if($rows > 0 ){
                                throw new Exception("you don't have any posts yet");
                        }
                }

                public function ShowOwnPosts()
                {
                        $conn = Db::getInstance();
                        $statement = $conn->prepare("SELECT * FROM posts, users WHERE posts.post_user_id = users.id 
                        AND post_user_id = :loggeduser
                        AND posts.active = 1 ORDER BY post_date desc limit 20");
                        $statement->bindValue(":loggeduser", $this->loggeduser);
                        $statement->execute();

                        return $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                public function Likes($post_likes)
                {
                        $conn = Db::getInstance();
                        $stmt = $conn->prepare("UPDATE liketable SET like_id = :post_likes WHERE post_id = :post_id"); 
                        $stmt->bindParam(":post_id", $this->post_id);
                        $stmt->bindParam(":post_likes", $post_likes);
                        $result = $stmt->execute();
                        return $result;
                }

                public function checkLike(){

                        $db = Db::getInstance();
                        $stmt = $db->prepare("SELECT * FROM liketable WHERE user_id = :user_id");
                        $stmt->bindValue(":user_id", $this->post_user_id);
                        $stmt->execute();
                
                        return $stmt->fetchAll();
                }

                
        }

?>