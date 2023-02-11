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
    }
}
