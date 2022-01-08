<?php
    class college {
        
        private $name;
        private $city;
        private $state;
        private $act;
        private $tuition;
        private $pros;
        private $cons;
        
        public function __construct($name, $city, $state, $act, $tuition, $pros, $cons) {
        
            $this->name = $name;
            $this->city = $city;
            $this->state = $state;
            $this->act = $act;
            $this->tuition = $tuition;
            $this->pros = $pros;
            $this->cons = $cons;
        }
        
        public function getName() {
            return $this->name;
        }
        
        public function getCity() {
            return $this->city;
        }
        
        public function getState() {
            return $this->state;
        }
        
        public function getAct() {
            return $this->act;
        }
        
        public function getTuition() {
            return $this->tuition;
        }
        
        public function getPros() {
            return $this->pros;
        }
        
        public function getCons() {
            return $this->cons;
        }
        
        public function insertIntoDatabase() {
        
            $name = getName();
            $city = getCity();
            $state = getState();
            $act = getAct();
            $tuition = getTuition();
            $pros = getPros();
            $cons = getCons();
            
            $query = "INSERT INTO college_CI (name, city_location, state_location," 
                    . " average_act, average_tuition, pros, cons)"
                    . "VALUES ('$name', '$city', '$state', '$act', '$tuition', '$pros',"
                    . " '$cons')";
           
           return $query;
        }
    }
?>
