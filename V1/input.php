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
        <label for="description">Description: </label>
        <input type="text" name="description" id="">
        <label for="Status">Status: </label>
        <select name="status" id="" title="Status">
            <option value="to-do">To_Do</option>
            <option value="in-progress">In-Progress</option>
            <option value="done">Done</option>
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
        

    ?>
</body>
</html>