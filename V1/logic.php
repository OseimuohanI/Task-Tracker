<?php

    require_once '/xampp/htdocs/Task-Tracker/V1/db_conn.php';

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

        public function NewTask($id, $des, $stat, $createdAt, $updatedAt)
        {
            $this;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $e = "In Progress...";
    } /*else{$e = "<br> Your Connection isn't Secure";}*/else if ($_SERVER['REQUEST_METHOD'] == 'GET') {header("location:". $_SERVER['PHP_SELF']. "?e" . $e); $e = "Your Connection isn't Secure";}
?>