## Initilizing the `Query` class

```php
<?php

// include your PDO object and the Query object
include './database.php';
include './Query.php';

// write your sql
$sql = 'SELECT * FROM `users`';

// Initize the query object
$users = (new Query($conn, $sql))->select();
// [[...], [...], [...], ...]

?>
```

Using with parameters with examples

```php
<?php

$sql = 'SELECT * FROM `users` WHERE id = ? AND name = ?';
$queryObj = new Query($conn, $sql);
$user = $queryObj->select([1, 'Jhon']);
$user[0];
// ["id" => 1, "name" => 'Jhon"]

$sql2 = 'INSERT INTO `users`(`id`, `name`) VALUES (?, ?)';
$user2 = (new Query($conn, $sql2))->insert([2, 'Peter']);
// ["insert_id" => 2]

// Using key parameters
$sql3 = 'DELETE FROM `users` WHERE id = :id';
$deleted = (new Query($conn, $sql3))->delete([':id' => 2]);
// ["affected_rows" => 1]

```

### Making it simple

```php
<?php

function query($q)
{
    global $conn;
    return new Query($conn, $q);
}

$data = query('SELECT * FROM `users`')->select();

```

### Available methods

The available methods are `select`, `insert`, `insertAll` `update`, `delete`, `execute`.
Each method have specific logic in handling the sql code.

```php
<?php

class Query
{
    /**
     * @param array $val
     * @return array
     */
    public function select(array $array = null) {}

    /**
     * @param array $val
     * @return array $arr['insert_id']
     */
    public function insert(array $array) {}
    public function insertAll(array $array) {}

    /**
     * @param array $val
     * @return array $arr['affected_rows']
     */
    public function update(array $array) {}
    public function delete(array $array) {}
    public function execute(array $array = []) {}
}

```

### Extending

If you have class the refers to your database table, you can use this approach.

```php
<?php

use Query;

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


```

Then extend the Model class

```php
<?php

class User extends Model
{
    public function all()
    {
        $sql = 'SELECT * FROM `users`';

        return $this->query($sql)->select();
    }

    ...
}

?>
```

Use the User class

```php
<?php

$userObj = new User($conn);

$users = $userObj->all();

```
