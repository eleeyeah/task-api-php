<?php

require_once('Task.php');

try {
    $task = new Task(1, 'Task 1 title ', 'This is task 1 description', '2020-12-12', 'N');
    header('Content-Type: application/json;charset=utf-8');
    echo json_encode($task->returnTaskAsArray());
} catch (TaskException $ex) {
    echo $ex->getMessage();
}
