<?php

// include your PDO object and the Query object
include './services/database.php';
include '../Query.php';

$sql = 'SELECT * FROM `users` WHERE id = ? AND name = ?';

$queryObj = new Query($conn, $sql);
$user = $queryObj->select([1, 'Jhon']);

print_r($user[0]); // ["id" => 1, "name" => 'Jhon"]


//  ===============================================================

$sql2 = 'INSERT INTO `users`(`id`, `name`) VALUES (?, ?)';

$user2 = (new Query($conn, $sql2))->insert([2, 'Peter']);

print_r($user2); // ["insert_id" => 2]

//  ===============================================================


// Using key parameters
$sql3 = 'DELETE FROM `users` WHERE id = :id';

$deleted = (new Query($conn, $sql3))->delete([':id' => 2]);

print_r($deleted);// ["affected_rows" => 1]
