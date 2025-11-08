<?php
    include_once 'db_conn.php';

    class Tasks{
        protected $id;
        //description
        public $des;
        //status
        public $stat;
        protected $createdAt;
        public $updatedAt;
        private $conn;

        public function __construct($des, $stat)
        {
            global $conn;
            $this->conn = $conn;
            $this->des = $des;
            $this->stat = $stat;
        }

        public function NewTask($des, $stat)
        {
            $date = new DateTime();
            $formatted_date = $date->format('Y-m-d H:i:s');
            $this->stat = $stat;
            $this->des = $des;
            $this->createdAt = $formatted_date;
            $this->updatedAt = $formatted_date;

            $sql = "INSERT INTO tasks (description, status, createdAt, updatedAt) VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssss", $this->des, $this->stat, $this->createdAt, $this->updatedAt);
            
            $result = $stmt->execute();
            $stmt->close();
            
            if ($result === TRUE) {
                return "New task successfully added";
            } else {
                return "Error: " . $this->conn->error;
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descri = $_POST['description'];
        $statu = $_POST['status'];
        $task = new Tasks($descri, $statu);
        
        $ech = $task->NewTask($descri, $statu);
        $dat = urlencode("Successfully Done");
        sleep(4);
        header('location: input.php' . "?e=" . $dat);
        exit();
    }
?>