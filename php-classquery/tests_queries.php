<?php

require_once 'classes\PDOConnection.php';
require_once 'classes\Query.php';
require_once 'classes\MainDB.php';

PDOConnection::init();
// or
// PDOConnection::connect('mysql', 'localhost', 'tests_usersdb', 'root', '');

// :)

// single select query
$jhon = (
    new Query(
	// database connection
        PDOConnection::$conn,
	// query
        "SELECT * FROM `user_info` WHERE `user_id` = ?"
    )
)->select([3]);

echo $jhon[0]['user_id'] . ' ' . $jhon[0]['user_fname'] . ' ' . $jhon[0]['user_lname'] . ' ' . $jhon[0]['user_adress'];
echo "<br/ ><br/ ><br/ >";

// multiple select query
$fname = 'jh';

$userslist = (
    new Query(
        PDOConnection::$conn,
        "SELECT * FROM `user_info` WHERE `user_fname` LIKE ?"
    )
)->select(["%$fname%"]);

foreach ($userslist as $key => $array) {
    echo $userslist[$key]['user_id'] . ' ' . $userslist[$key]['user_fname'] . ' ' . $userslist[$key]['user_lname'] . ' ' . $userslist[$key]['user_adress'];
    echo "<br />";
}

echo "<br/ ><br/ ><br/ >";

// single insert query
$insert = (
    new Query(
        PDOConnection::$conn,
        "INSERT INTO `user_info` (`user_fname`, `user_lname`, `user_adress`) VALUES (?, ?, ?)"
    )
)->insert(['qqq', 'qq', 'qq']);

echo $insert['insert_id']; // possile value: insert id or false, not added

echo "<br/ ><br/ ><br/ >";

// multiple insert query
$insertAll = (
    new Query(
        PDOConnection::$conn,
        "INSERT INTO `user_info` (`user_fname`, `user_lname`, `user_adress`) VALUES (?, ?, ?)"
    )
)->insert(
    [
        ['wwwww', 'lnameqq', 'addrr1'],
        ['zzzzqqss', 'lanemwww', 'addr2'],
        ['zzzzqqss', 'lanemwww', 'addr2']
    ]
);

foreach ($insertAll['insert_id'] as $k => $id) {
    echo $id;
    echo "<br />";
}

echo "<br/ ><br/ ><br/ >";

$update = (
    new Query(
        PDOConnection::$conn,
        "UPDATE `user_info` SET `user_fname` = ?, `user_adress` = ? WHERE `user_id` = ?"
    )
)->update(['lkzzzzz', 'calauaggggs', 10]);

echo $update['affected_rows'];

echo "<br/ ><br/ ><br/ >";

$deleteThis = (
    new Query(
        PDOConnection::$conn,
        "DELETE FROM `user_info` WHERE `user_id` = ?"
    )
)->delete([8]);

echo $deleteThis['affected_rows'];

echo "<br/ ><br/ ><br/ >";

/**
 * query function
 * for database tests_usersdb
 *
 * @param string $sql
 * @param array $data
 * @param string $function  'select', 'insert', 'update', 'delete', 'execute'
 * @return array
 */
function query($sql, $data = [], $function = 'select') {
    return (new Query(PDOConnection::$conn, $sql))->{$function}($data);
}

print_r(query("SELECT * FROM `user_info` WHERE `user_id` = ?", [4]));

//$data = MainDB::query('SELECT * FROM `table`');
