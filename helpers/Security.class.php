<?php

    class Security {
        public $password;
        public $passwordConfirmation;
        public $username;
        

        

        

        public function passwordsAreSecure(){
            if($this->passwordsAreEqual() && $this->passwordStrongEnough()) {
                return true;
            }
            else {
                return false;
            }
        }

        private function passwordStrongEnough(){
            if(strlen($this->password) < 8 ) {
                throw new Exception("Password must be longer than 8 characters.");
            }
            
            return true;
        }

        private function passwordsAreEqual(){
            if( $this->password !== $this->passwordConfirmation ) {
                throw new Exception("Password must be equal.");
            }
            
            return true;
        }
    }

?>