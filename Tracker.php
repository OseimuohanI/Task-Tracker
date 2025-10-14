<?php

    $tasks = [
        // "Him" => "Him"
    ];
       
    function AddTask(){
        global $tasks;
        $New_Task = readline("Enter a new Task: ");
        if (isset($New_Task)){
            // array_push($tasks, $New_Task);
            $tasks[count($tasks) + 1] = $New_Task;
            return printArray();
        }

    }
    function printArray(){
        global $tasks;
        // foreach ($tasks as $task => $tasko) {
        //     return $task . " and " . $tasko;
        // }
        foreach ($tasks as $task) {
            return $task;
        }
    }
   
    if (!isset($tasks) || $tasks == []){
        echo AddTask();
    }else if (isset($tasks) && count($tasks) >= 1){
        $input1 = readline("Would you like to review your tasks? y/n ");
        if (isset($input1)){
            if ($input1 == "y" || $input1 == "n" || $input1 == "N" || $input1 == "Y"){
                if ($input1 == "y" || $input1 == "Y"){
                    echo printArray($tasks);
                    
                } else if ($input1 == "n" || $input1 == "N"){
                    echo "Thank you for your Time";
                }
            } else{
                echo "Retry";
            }
        } else {
            echo "Retry";
        }
    }
?>