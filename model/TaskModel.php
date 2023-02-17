<?php


// TaskException class is used to create a new TaskException object

class TaskException extends Exception
{
}

// Task class is used to create a new task object

class Task
{

    //The Getters - Private variables are used to store the values of the task object

    private $_id;
    private $_title;
    private $_description;
    private $_deadline;
    private $_completed;



    // a construct method is used to create a new object and set the values of the private variables to the values of the parameters of the construct method based on the setters

    public function __construct($id, $title, $description, $deadline, $completed)
    {

        $this->setID($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDeadline($deadline);
        $this->setCompleted($completed);
    }



    public function getID()
    {
        return $this->_id;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getDeadline()
    {
        return $this->_deadline;
    }

    public function getCompleted()
    {
        return $this->_completed;
    }


    // The Setters are used to check if the values are valid



    //Check if the id is valid
    public function setID($id)
    {

        if (($id !== null) && (!is_numeric($id)) || $id <= 0 || $id > 9223372036854775807 || $this->_id !== null) {
            throw new TaskException('TaskID error - id must be a valid integer');
        }
        $this->_id = $id;
    }


    //Check if the title is valid
    public function setTitle($title)
    {

        if (strlen($title) < 1 || strlen($title) > 255) { //The title must be between 1 and 255 characters. The strlen() function is used to get the length of a string
            throw new TaskException('Task title error - title must be between 1 and 255 characters');
        }
        $this->_title = $title;
    }


    //Check if the description is valid
    public function setDescription($description)
    {

        if ($description !== null && strlen($description) > 16777215) { //The description must be between 1 and 16777215 characters. The strlen() function is used to get the length of a string
            throw new TaskException('Task description error ');
        }
        $this->_description = $description;
    }


    //Check if the deadline is valid
    public function setDeadline($deadline)
    {


        if (($deadline !== null) && date_format(date_create_from_format('d/m/Y H:i', $deadline), 'd/m/Y H:i') != $deadline) {
            throw new TaskException('Task deadline error - must be a valid date/time'); //The date_format() function is used to format a date/time according to a specified format and the date_create_from_format() function is used to create a DateTime object from a string with a specified format  
        }
        $this->_deadline = $deadline;
    }


    //Check if the completion is valid
    public function setCompleted($completed)
    {

        if (strtoupper($completed) !== 'Y' && strtoupper($completed) !== 'N') {
            throw new TaskException('Task completion error - must be Y or N');
        }
        $this->_completed = $completed;
    }


    //Convert the task object to an array

    public function returnTaskAsArray()
    {
        $task = array();
        $task['id'] = $this->getID();
        $task['title'] = $this->getTitle();
        $task['description'] = $this->getDescription();
        $task['deadline'] = $this->getDeadline();
        $task['completed'] = $this->getCompleted();
        return $task;
    }
}
