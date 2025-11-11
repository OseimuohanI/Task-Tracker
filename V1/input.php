<?php

    $e = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do | V1</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function toggleMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');
            body.classList.toggle('light-mode');
            const icon = document.getElementById('mode-icon');
            icon.classList.toggle('fa-sun');
            icon.classList.toggle('fa-moon');
            localStorage.setItem('mode', body.classList.contains('dark-mode') ? 'dark' : 'light');
        }

        window.onload = function() {
            const mode = localStorage.getItem('mode');
            const icon = document.getElementById('mode-icon');
            if (mode === 'dark') {
                document.body.classList.add('dark-mode');
                icon.classList.add('fa-sun');
            } else {
                document.body.classList.add('light-mode');
                icon.classList.add('fa-moon');
            }
        }
    </script>
</head>
<body>
    <nav>
        <button id="toggle-button" onclick="toggleMode()">
            <i id="mode-icon" class="fas"></i>
        </button>
        <form action="/V1/logic.php" method="POST" novalidate autocomplete="off">
            <input type="hidden" name="action" value="add_task">
            <label for="description">Task: </label>
            <input type="text" name="description" id="">
            <label for="priority">Priority: </label>
            <select name="priority" id="">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <label for="Status">Status: </label>
            <select name="status" id="" title="Status">
                <option value="to-do">To_Do</option>
                <option value="in-progress">In-Progress</option>
                <option value="done">Done</option>
            </select>
            <label for="category">Category: </label>
            <select name="category" id="">
                <option value="work">Work</option>
                <option value="personal">Personal</option>
                <option value="other">Other</option>
            </select>
            <button type="submit">Add Task</button>
        </form>
    </nav>
    <br>

    <?php

    include_once 'logic.php';
    if (isset($_GET['e']) && !empty($_GET['e'])){
        $e = urldecode($_GET['e']);
        echo "<div class='flash'>".htmlspecialchars($e, ENT_QUOTES, 'UTF-8')."</div>";
    }
   
    echo "<form action='logic.php' method='POST'>";
    echo "<input type='hidden' name='action' value='update_tasks'>";
    include_once 'db_conn.php';
    
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Description</th><th>Priority</th><th>Status</th><th>Category</th><th>Created At</th><th>Updated At</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<input type='hidden' name='task_id[]' value='" . $row["id"] . "'>";
            echo "<td>" . $row["id"] . "</td><td>" . $row["description"] . "</td><td>
            <select name='priority[]' title='Priority'>
            <option value='low'" . ($row["priority"] == 'low' ? ' selected' : '') . ">Low</option>
            <option value='medium'" . ($row["priority"] == 'medium' ? ' selected' : '') . ">Medium</option>
            <option value='high'" . ($row["priority"] == 'high' ? ' selected' : '') . ">High</option>
            </select>
            </td><td>            
            <select name='status[]' title='Status'>
                <option value='to-do'" . ($row["status"] == 'to-do' ? ' selected' : '') . ">To_Do</option>
                <option value='in-progress'" . ($row["status"] == 'in-progress' ? ' selected' : '') . ">In-Progress</option>
                <option value='done'" . ($row["status"] == 'done' ? ' selected' : '') . ">Done</option>
            </select>
            </td><td>
            <select name='category[]' title='Category'>
                <option value='other'" . ($row["category"] == 'other' ? ' selected' : '') . ">Other</option>
                <option value='work'" . ($row["category"] == 'work' ? ' selected' : '') . ">Work</option>
                <option value='personal'" . ($row["category"] == 'personal' ? ' selected' : '') . ">Personal</option>
            </select>
            </td><td>" . $row["createdAt"] . "</td><td>" . $row["updatedAt"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No tasks found";
    }
    
    $conn->close();

    echo "<div class='button-container'><button type='submit'>Save</button></div>";
    echo "</form>";
    ?>
</body>
</html>