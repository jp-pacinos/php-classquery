<?php

include './services/database.php';
include './classes/User.php';

$userObj = new User($conn);

$users = $userObj->all();

print_r($users);
