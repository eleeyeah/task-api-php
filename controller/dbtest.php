<?php

require_once('db.php'); // this line is to require the db.php file
require_once('../model/Response.php'); // this line is to require the Response.php file in order to use the Response class


try {
    $writeDB = DB::connectWriteDB(); // this line is to connect to the writeDB an test the POST, PUT and DELETE requests
    $readDB = DB::connectReadDB(); // this line is to connect to the readDB an test the GET requests
} catch (PDOException $ex) {
    $response = new Response(); // this line is to create a new Response object based on the class Response and store it in the variable $response
    $response->setHttpStatusCode(500);
    $response->setSuccess(false);
    $response->addMessage($ex->getMessage()); // shows the error code
    $response->send();
    exit;
}
