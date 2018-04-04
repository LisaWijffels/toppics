<?php

    class Security {
        public $password;
        public $passwordConfirmation;
        public $username;
        

        

        

        public function passwordsAreSecure(){
            if($this->passwordsAreEqual() ) {
                return true;
            }
            else {
                return false;
            }
        }

        private function passwordStrongEnough(){
            if(strlen($this->password) >= 8 ) {
                return false;
                echo "strlen false";
            }
            else {
                return true;
                echo "Same pw false";
            }
        }

        private function passwordsAreEqual(){
            if( $this->password == $this->passwordConfirmation ) {
                return true;
                echo "Same pw false";
            }
            else {
                return false;
                echo "Same pw false";
            }
        }
    }

?>