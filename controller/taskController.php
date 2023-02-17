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
    exit;
}
