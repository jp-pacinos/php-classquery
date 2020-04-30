<?php

$conn = new PDO(
    'mysql:host=localhost;port=3306;dbname=example',
    'root',
    '',
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

return $conn;
