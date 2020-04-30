<?php

include '../Query.php';

abstract class Model
{
    private $connection = null;

    public function __construct($conn = null)
    {
        $this->connection = $conn;
    }

    /**
     * this is where query object live
     */
    public function query($sql)
    {
        return new Query($this->connection, $sql);
    }
}
