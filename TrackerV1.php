<?php
    class Tasks{
        protected $id;
        //description
        public $des;
        //status
        public $stat;
        public $createdAt;
        public $updatedAt;

        public function __construct($id, $des, $stat, $createdAt, $updatedAt)
        {
            $this->id = $id;
            $this->des = $des;
            $this->stat = $stat;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }

        public function NewTask()
        {
            
        }
    }
?>