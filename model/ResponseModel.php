<?php

class Response
{
    private $_success; // boolean
    private $_httpStatusCode; // 200, 400, 500, etc
    private $_messages = array(); // array of messages
    private $_data; // data to be returned to the user
    private $_toCache = false; // if we want to cache the response
    private $_responseData = array(); // array of data to be returned to the user

    // constructor method

    public function setSuccess($success)
    {
        $this->_success = $success; // set the success property

    }
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->_httpStatusCode = $httpStatusCode; // set the http status code property

    }

    public function addMessage($message)
    {
        $this->_messages[] = $message; // add a message to the messages array

    }

    public function setData($data)
    {
        $this->_data = $data; // set the data property

    }

    public function toCache($toCache)
    {
        $this->_toCache = $toCache; // set the toCache property

    }

    // send method

    public function send()
    {

        header('Content-type: application/json;charset=utf-8'); // a php function to set the header to json 

        if ($this->_toCache == true && $this->_success == true) {
            header('Cache-control: max-age=60'); // if we want to cache the response, set the cache-control header to 60 seconds
        } else {
            header('Cache-control:no-cache, no-store'); // if we don't want to cache the response, set the cache-control header to no-cache and no-store
        }

        if (($this->_success !== false && $this->_success !== true) || !is_numeric($this->_httpStatusCode)) {
            http_response_code(500); // if the success property is not a boolean, set the http response code to 500

            $this->_responseData['statusCode'] = 500; // set the status code to 500
            $this->_responseData['success'] = false; // set the success property to false
            $this->addMessage('Response creation error'); // add a message to the messages array
            $this->_responseData['messages'] = $this->_messages; // set the messages property to the messages array
        } else {
            http_response_code($this->_httpStatusCode); // if the success property is a boolean, set the http response code to the http status code property
            $this->_responseData['statusCode'] = $this->_httpStatusCode; // set the status code to the http status code property
            $this->_responseData['success'] = $this->_success; // set the success property to the success property
            $this->_responseData['messages'] = $this->_messages; // set the messages property to the messages array
            $this->_responseData['data'] = $this->_data; // set the data property to the data property

        }

        echo json_encode($this->_responseData); // encode the response data array to json and echo it
    }
}
