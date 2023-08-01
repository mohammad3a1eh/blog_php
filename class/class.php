<?php
require_once "config.php";
class database {
    private $connect;
    private $result;
    private $fetch;
    function start()
    {
        $this->connect = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');
    }
    function setQuery($query)
    {
        $this->result = mysqli_query($this->connect, $query);
    }
    function fetch_all()
    {
        $this->fetch = mysqli_fetch_all($this->result);
    }
    function fetch_assoc()
    {
        $this->fetch = mysqli_fetch_assoc($this->result);
    }
    function fetch_row()
    {
        $this->fetch = mysqli_fetch_row($this->result);
    }
    function fetch_array()
    {
        $this->fetch = mysqli_fetch_array($this->result);
    }
    function getFetch()
    {
        return $this->fetch;
    }
    function getQueryResult()
    {
        return $this->result;
    }
}
