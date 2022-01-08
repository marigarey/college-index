<?php
    class user {
    
        private $user_name;
        private $password;
        private $access;
        private $first_name;
        private $last_name;
        
        public function __construct($user_name, $password) {
            $this->user_name = $user_name;
            $this->password = $password;
        }
        
        public function __construct($access, $first_name, $last_name) {
            $this->access = $access,
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }
        
        public function getAccess() {
            $this->access;
        }
        
        public funcion getFirstName() {
            $this->first_name;
        }
        
        public function getLastName() {
            $this->last_name;
        }
        
        public function insertIntoDatabase() {
            $query = "INSERT INTO user_CI (user_name, password_hash, access_privileges, first_name, last_name)"
                    . " VALUES ('$user_name', '$password', '$access', '$first_name', '$last_name')";
            return $query;
        }
    }
?>
