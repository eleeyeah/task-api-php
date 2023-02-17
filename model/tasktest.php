<?php

require_once('Task.php');

try {
    $task = new Task(1, 'Task 1 title ', 'This is task 1 description', '23/12/2023 12:00', 'N');
    header('Content-Type: application/json;charset=utf-8');
    echo json_encode($task->returnTaskAsArray());
} catch (TaskException $ex) {
    echo "Error:", $ex->getMessage();
}
