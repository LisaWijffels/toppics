<?php
include_once('Db.class.php');

class Block{
    private $id;
    private $post_id;
    private $user_id;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
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
        $statement = $db->prepare("INSERT INTO blocked (user_id, post_id) VALUES (:user_id, :post_id)");
        $statement->bindValue(":user_id", $this->user_id);
        $statement->bindValue(":post_id", $this->post_id);
        

        return $statement->execute();

    }

    public function Count(){
        $db = Db::getInstance();
        $statement = $db->prepare("SELECT * FROM blocked WHERE post_id = :post_id");
        
        $statement->bindValue(":post_id", $this->post_id);
        $statement->execute();

        $count = $statement->rowCount();

        return $count;
    }

    public function checkBlock(){
        $db = Db::getInstance();
        $statement = $db->prepare("SELECT * FROM blocked WHERE user_id = :user_id");
        
        $statement->bindValue(":user_id", $this->user_id);
        
        $statement->execute();

        return $statement->fetchAll();
    }

    public function Remove(){
        $conn = Db::getInstance();
        $stm = $conn->prepare("DELETE FROM blocked WHERE post_id = :post_id AND user_id = :user_id");
        $stm->bindValue(":user_id", $this->user_id);
        $stm->bindValue(":post_id", $this->post_id);
        $result = $stm->execute();
        return $result;

    }
}

