<?php

// include your PDO object and the Query object
include './services/database.php';
include '../Query.php';

// write your sql
$sql = 'SELECT * FROM `users`';

// Initize the query object
$users = (new Query($conn, $sql))->select();

print_r($users);
