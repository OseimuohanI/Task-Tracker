<?php

    $e = "";
    // include 'logic.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do | V1</title>
</head>
<body>
    <form action="logic.php" method="POST" novalidate autocomplete="off">
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
    <br>

    <?php

    include_once 'logic.php';
    if (isset($_GET['e']) && !empty($_GET['e'])){
        $e = urldecode($_GET['e']);
        echo $e;
    }
    
    include_once 'db_conn.php';
    
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Description</th><th>Priority</th><th>Status</th><th>Category</th><th>Created At</th><th>Updated At</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["description"] . "</td><td>
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

    ?>
    <a href="ChangeStatus.php">Edit</a>
</body>
</html>