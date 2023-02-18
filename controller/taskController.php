<?php

require_once('dbController.php');
require_once('../model/taskModel.php ');
require_once('../model/responseModel.php');


try {

    // this is the connection to the database
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
} catch (PDOException $ex) {
    error_log("Connection error - " . $ex, 0);
    // We want to log the error in the server 
    // Sometime you don't want to display the true exception to the user, ecause of security reasons - so you use error_log method instead 
    // The first parameter is the message, the second is the destination of the message, 0 means that the message will be sent to the server's system logger
    $response = new Response();
    $response->setHttpStatusCode(500);
    $response->setSuccess(false);
    $response->addMessage("Database connection error");
    $response->send();
    exit();
}



// this is the function that will handle the GET requests

if (array_key_exists('taskid', $_GET)) {

    $taskid = $_GET['taskid'];

    if ($taskid = '' || !is_numeric($taskid)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Task ID cannot be blank and must be numeric");
        $response->send();
        exit();
    }


    // this is the query that will be executed in the database to GET DELETE UPDATE

    if ($_SERVER['REQUEST_METHOD' === 'GET']) {

        try {

            $query = $readDB->prepare('select id, title, description, DATE_FORMAT(deadline, %d/%m/%Y %H:%i"), completed from tbltasks where id = :taskid');
            // the :taskid is a placeholder where we will bind a variable
            // the DATE_FORMAT is a MySQL function that will format the date to the format that we want

            $query->bindParam(':taskid', $taskid, PDO::PARAM_INT);
            // the bindPARAM is to bind the variable to the placeholder 
            // the PDO::PARAM_INT is to make sure that the variable is an integer

            $query->execute();


            $rowCount = $query->rowCount(); // this is to check if the query returned any rows



            if ($rowCOunt === 0) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage('Task not found');
                $reponse->send();
                exit();
                // if the query returned 0 rows, then the task was not found
                // we send a 404 response
                // we exit the script

            }


            // if the query was successful, then we will fetch the task from the database

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                // the fetch method will return the next row from the result set as an associative array

                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['completed']);
                // we create a new task object and we pass the values from the database to the constructor( taskModel.php)
                // the constructor will validate the data and set the values to the properties of the object
                // we will use the get method to get the values from the object and put them in the response

                $taskArray[] = $task->returnTaskAsArray();
                // we create an array and we put the task in it even though there is only one task 
            }


            $returnData = array();
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;
            // we create an array and we put the number of rows returned and the task in it
            // we will send this array as a response
            // we will use the returnData array to send the response
            // we will use the taskArray to send the task
            // we will use the rowCount to send the number of rows returned


            $response = new Response();
            $response->setHttpStatusCode(200);
            $response->setSuccess(true);
            $response->toCache(true); // we want to cache the response 
            $response->setData($returnData);
            $response->send();
            exit();
            // we send the response with the data that we want to send to the user 


        } catch (TaskException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage()); // sends the custom message that we created in the taskModel.php
            $response->send();
            exit();
        } catch (PDOException $ex) {
            error_log("Database query error - " . $ex);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage('Failed to get Task');
            $response->send();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD' === 'DELETE']) {
    } elseif ($SERVER_METHOD['REQUEST_METHOD' === 'PATCH']) {
    } else {
    }
}
