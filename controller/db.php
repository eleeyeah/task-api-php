<?php

class DB
{
    private static $writeDBConnection;
    private static $readDBConnection; // the write and read variables main purpose is to make the scalability easier in the future


    public static function connectWriteDB()
    {

        if (self::$writeDBConnection === null) {
            self::$writeDBConnection = new PDO('mysql:host=localhost;dbname=taskdb;charset=utf8', 'root', '');
            // PDO is the class that connects to the database
            // the first parameter is the connection string(host,db,charset), the second is the username and the third is the password

            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // this line is to set the error mode to exception
            // exceptions are a good way to error handle in PHP

            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // not every database supports prepared statements, this line is to make sure that the database supports prepared statements
            // prepared statements are a way to prevent SQL injection
            // in our case we are using MySQL which supports prepared statements therefore is set to false
        }

        return self::$writeDBConnection;
    }

    // the readDBConnection is the same as the writeDBConnection, the only difference is that the readDBConnection is used for the GET requests and the writeDBConnection is used for the POST, PUT and DELETE requests. This is because the GET requests are read only and the POST, PUT and DELETE requests are write only. this is to make sure that the database is not overloaded with requests 


    public static function connectreadDB()
    {

        if (self::$readDBConnection === null) {
            self::$readDBConnection = new PDO('mysql:host=localhost;dbname=taskdb;charset=utf8', 'root', '');
            // PDO is the class that connects to the database
            // the first parameter is the connection string(host,db,charset), the second is the username and the third is the password

            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // this line is to set the error mode to exception
            // exceptions are a good way to error handle in PHP

            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // not every database supports prepared statements, this line is to make sure that the database supports prepared statements
            // prepared statements are a way to prevent SQL injection
            // in our case we are using MySQL which supports prepared statements therefore is set to false
        }

        return self::$readDBConnection;
    }
}
