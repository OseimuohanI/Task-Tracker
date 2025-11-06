<?php

    $increment = 1;
    $tasks = [];
    $progress = [];
       
    function AddTask(){
        global $tasks;
        global $progress;
        global $progres;
        global $increment;
        $New_Task = readline("Enter a new Task: ");
        if (isset($New_Task) && $New_Task != ""){
            // return var_dump($New_Task) . var_dump($progres);
            array_push($tasks, $New_Task);
            // $increment += 1;
            array_push($progress, $increment);
            // $tasks[count($tasks) + 1] = $New_Task;
            // $tasks[arraycount($tasks)] = $New_Task;
            // $progress[count($progress) + 1] = 0;
            // $progress[arraycount($progress)] = 1;
            return printArray() . var_dump($progres);
        } else {return "Try Again";}
        // $decision = readline("")

    }

    function arraycount($array){
        global $increment;
        if ($array == []){
            return 0;
        } else if (count(array_keys($array)) >= 1){
            $increment += 1;
            return $increment;
        }
    }

    function determineProgress($x){
        global $tasks;
        global $progress;
        if (count($tasks) == count($progress)){
            // return $x;
            foreach ($progress as $key => $progres){
                if ($progress[$key] == 0){
                    return " In progress";
                } else if ($progress[$key] == 1){
                    return " Task Completed";
                } else {return "error";}
            }
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
            return $task . determineProgress(arraycount($progress));
            // return arraycount($tasks) . ' ArrayCount For ';
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
                        $choice = readline("Which Task would you like to change status for? ");
                            if (isset($choice)){
                                $choice -= 1;
                            }
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
