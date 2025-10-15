<?php

    $tasks = [
        // "Him" => "Him"
    ];

    $progress = [];
       
    function AddTask(){
        global $tasks;
        global $progress;
        $New_Task = readline("Enter a new Task: ");
        if (isset($New_Task)){
            // array_push($tasks, $New_Task);
            $tasks[count($tasks) + 1] = $New_Task;
            $progress[count($progress) + 1] = 1;
            return printArray();
        }
        // $decision = readline("")

    }

    function determineProgress($x){
        global $progress;
        if ($progress[$x] == 0){
            return " In progress";
        } else if ($progress[$x] == 1){
            return " Task Completed";
        }
    }
    
    function printArray(){
        global $tasks;
        global $progress;
        // global $determineProgress;
        // foreach ($tasks as $task => $tasko) {
        //     return $task . " and " . $tasko;
        // }

        if (count($tasks) == count($progress)) {
            foreach ($tasks as $task) {
                
            }
            foreach ($progress as $progres) {
                // (int)$progres;
            }
            return $task . determineProgress((int) $progres);
        }
        
    }

    if (isset($tasks)){
        if ($tasks == []){
            echo AddTask();
        }else if (count($tasks) >= 1){
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
    }
?>