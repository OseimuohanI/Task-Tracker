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

        public function UpdateTask($id, $stat, $priority, $category)
        {
            $sql = "SELECT status, priority, category FROM tasks WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $current = $result->fetch_assoc();
            $stmt->close();
            
            if ($current['status'] === $stat && 
                $current['priority'] === $priority && 
                $current['category'] === $category) {
                return true;
            }
            
            $this->id = $id;
            $this->stat = $stat;
            $this->priority = $priority;
            $this->category = $category;
            $this->updatedAt = (new DateTime())->format('Y-m-d H:i:s');
            
            $sql = "UPDATE tasks SET status = ?, priority = ?, category = ?, updatedAt = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $this->stat, $this->priority, $this->category, $this->updatedAt, $this->id);

            $result = $stmt->execute();
            $stmt->close();

            return $result;
        }
    }

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'add_task') {
            $descri = $_POST['description'];
            $statu = $_POST['status'];
            $prio = $_POST['priority'];
            $cat = $_POST['category'];
            $task = new Tasks($descri, $statu, $prio, $cat);
            
            $ech = $task->NewTask($descri, $statu, $prio, $cat);
            $data = urlencode($ech);
            header("location: input.php?e=" . $data);
            exit();
        } elseif ($action === 'update_tasks') {
            $task_ids = $_POST['task_id'] ?? [];
            $statuses = $_POST['status'] ?? [];
            $priorities = $_POST['priority'] ?? [];
            $categories = $_POST['category'] ?? [];
            
            $successCount = 0;
            $errorCount = 0;
            
            for ($i = 0; $i < count($task_ids); $i++) {
                $task = new Tasks('', '', '', '');
                if ($task->UpdateTask($task_ids[$i], $statuses[$i], $priorities[$i], $categories[$i])) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }
            
            $message = "$successCount task(s) processed";
            if ($errorCount > 0) {
                $message .= ", $errorCount error(s) occurred";
            }
            
            header("location: input.php?e=" . urlencode($message));
            exit();
        }
    }

    /*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['description'])) {
            $descri = $_POST['description'];
            $statu = $_POST['status'];
            $prio = $_POST['priority'];
            $cat = $_POST['category'];
            $task = new Tasks($descri, $statu, $prio, $cat);
            
            $ech = $task->NewTask($descri, $statu, $prio, $cat);
            $data = urlencode($ech);
            sleep(4);
            header("location: input.php?e=" . $data);
            exit();
        } elseif (isset($_POST['status']) && is_array($_POST['status'])) {
            header("location: input.php?e=" . urlencode("Tasks updated successfully"));
            exit();
        }
    }*/
?>