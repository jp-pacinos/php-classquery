<?php

class MainDB extends PDOConnection
{
    public static function init()
    {
        return parent::connect('mysql', 'localhost', 'mytestdb', 'root', '');
    }

    /**
     * CRUD functions
     */
    public static function query($sql, $function = 'select', $value = [])
    {
        return (new Query(parent::$conn, $sql))->{$function}($value);
    }
}
