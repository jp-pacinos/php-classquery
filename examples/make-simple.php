<?php

// include your PDO object and the Query object
include './services/database.php';
include '../Query.php';

function query($q)
{
    global $conn;
    return new Query($conn, $q);
}

$sql = 'SELECT * FROM `users`';

$data = query($sql)->select();

print_r($data);
// Array ( [0] => Array ( [id] => 1 [name] => Jhon ) )
