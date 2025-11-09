<?php
    include_once 'db_conn.php';

    class Tasks{
        protected $id;
        //description
        public $des;
        public $priority;
        //status
        public $stat;
        public $category;
        protected $createdAt;
        public $updatedAt;
        private $conn;

        public function __construct($des, $stat, $priority, $category)
        {
            global $conn;
            $this->conn = $conn;
            $this->des = $des;
            $this->stat = $stat;
            $this->priority = $priority;
            $this->category = $category;
        }

        public function NewTask($des, $stat, $priority, $category)
        {
            $date = new DateTime();
            $formatted_date = $date->format('Y-m-d H:i:s');
            $this->stat = $stat;
            $this->des = $des;
            $this->priority = $priority;
            $this->category = $category;
            $this->createdAt = $formatted_date;
            $this->updatedAt = $formatted_date;

            $sql = "INSERT INTO tasks (description, priority, status, category, createdAt, updatedAt) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $this->des, $this->priority, $this->stat, $this->category, $this->createdAt, $this->updatedAt);
            
            $result = $stmt->execute();
            $stmt->close();
            
            if ($result === TRUE) {
                return "New task $this->des successfully added";
            } else {
                return "Error: " . $this->conn->error;
            }
        }

        public function ChangeStatus()
        {
            $this->id = mysqli_insert_id($this->conn);
            if (isset($this->id)){
                $this->updatedAt = (new DateTime())->format('Y-m-d H:i:s');
                $sql = "UPDATE tasks SET status = ?, updatedAt = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssi", $this->stat, $this->updatedAt, $this->id);

                $result = $stmt->execute();
                $stmt->close();

                if ($result === TRUE) {
                    return "Task status updated successfully";
                } else {
                    return "Error updating status: " . $this->conn->error;
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descri = $_POST['description'];
        $statu = $_POST['status'];
        $prio = $_POST['priority'];
        $cat = $_POST['category'];
        $task = new Tasks($descri, $statu, $prio, $cat);
        
        $ech = $task->NewTask($descri, $statu, $prio, $cat);
        $data = urlencode("$ech" . " ");
        sleep(4);
        header("location: input.php?e=" . $data);
        exit();
    }
?>