<?php
    /*
        this is a function that checks if a user can login
        and return TRUE or FALSE
    */
    
    function canILogin ($p_username, $p_password){
        $conn = new mysqli("localhost:3307", "root", "", "netflix");
        
        $query = "select * from users where email = '".$conn->real_escape_string($p_username)."'";
        $result = $conn->query($query);
        
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            if(password_verify($p_password, $user['password']) ){
                return true;
            } /*else {
                return false;
            }
        }else{*/
            return false;
        }
            
        
    }



?>