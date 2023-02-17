<?php

require_once('ResponseModel.php');

$response = new Response();

$response->setSuccess(true); // set the success property to true

$response->setHttpStatusCode(200); // set the http status code to 200

$response->addMessage("Message 1"); // add a message to the messages array

$response->addMessage("Message 2"); // add a message to the messages array

$response->send(); // send the response