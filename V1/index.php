<?php

    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
        // Connection is not secure
        sleep(1.5);
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    } else {sleep(1.5); header('location: input.php'); exit();}
    
?>