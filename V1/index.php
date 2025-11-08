<?php

    $e = "";
    // include 'logic.php';
    include 'db_conn.php';

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do | V1</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" novalidate autocomplete="off">
        <label for="Description">Description: </label>
        <input type="text" name="description" id="">
        <label for="Status">Status: </label>
        <select name="status" id="">
            <option value="">NILL</option>
            <option value="to-do">To_Do</option>
            <option value="in-progress">In-Progress</option>
            <option value="done">Done</option>
        </select>
        <button type="submit">Add Task</button>
    </form>
    <br>
    <?php

    if (isset($e) && is_string($e)){
        echo $e;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        include 'logic.php';
    }else if ($_SERVER['REQUEST_METHOD'] === 'GET') {$e = "Your Connection isn't Secure"; header("location:". $_SERVER['PHP_SELF']. "?e=" . $e);}
    
        

    ?>
</body>
</html>