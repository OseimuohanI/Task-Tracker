<?php

    $increment = 0;
    $tasks = [];
    $progress = [];

    function Authenticate($x){
        if (isset($x) && !empty($x) || $x != ""){
            return 1;
        } else {return 0;}
    }
       
    function AddTask(){
        global $tasks;
        global $progress;
        global $increment;
        $New_Task = readline("Enter a new Task: ");
        if (isset($New_Task) && $New_Task != ""){
            array_push($tasks, $New_Task);
            array_push($progress, $increment);
            if (determineProgress() == "Error"){
                return "Error... Try Again";
            } else{
                return "Task Saved Successfully... " . printArray();
            }
        } else {return "Try Again";}
    }

    //arraycount() no longer needed
    function arraycount($array){
        global $increment;
        if ($array == []){
            return 0;
        } else if (count(array_keys($array)) >= 1){
            $increment += 1;
            return $increment;
        }
    }

    function determineProgress(){
        global $tasks;
        global $progress;
        if (count($tasks) == count($progress)){
            foreach ($progress as $key => $value){
                if ($progress[$key] == 0){
                    return "In progress";
                } else if ($progress[$key] == 1){
                    return "Task Completed";
                } else {return "Error";}
            }
        }
    }
    
    function printArray(){
        global $tasks;
        global $progress;
        if (count($tasks) == count($progress)) {
            foreach ($tasks as $task) {$i = 1; return $i++ . ". Task " . $task . ": " . determineProgress() . " ";}
        }
    }

    for ($i = 1; $i <= 2; $i++){
        if (isset($tasks)){
            if ($tasks == []){
                echo AddTask();
            }else if (count($tasks) >= 1){
                $input1 = readline(" Would you like to review your tasks? y/n ");
                if (isset($input1)){
                    if ($input1 == "y" || $input1 == "n" || $input1 == "N" || $input1 == "Y"){
                        if ($input1 == "y" || $input1 == "Y"){
                            echo printArray($tasks);
                            $choice = readline(" Which Task would you like to change status for? ");
                                if (isset($choice) && ctype_digit($choice) ){
                                    $choice -= 1;
                                    $choice = (int)$choice;
                                    // echo $choice;
                                    if ($progress[$choice] == 0){
                                        $progress[$choice] = 1; echo printArray();
                                    } else if ($progress[$choice] == 1){
                                        $progress[$choice] = 0; echo printArray();
                                    } else{ echo "Error";}
                                } else {
                                    echo "Input a number";
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
    }
?>
