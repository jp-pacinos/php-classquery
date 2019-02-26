<?php

/**
 * Class for singleton database connection using PDO
 */
class PDOConnection
{
    /**
     * @var int instance
     */
    private static $init = 0;

    /**
     * connection
     * use it like this PDOConnection::$conn
     *
     * @var null
     */
    public static $conn = null;

    /**
     * @var string defaults
     */
    private static $driver = '';                // mysql
    private static $host = '';                  // localhost
    private static $database = '';
    private static $database_port = '3306';     // 3306
    private static $user = '';                  // root
    private static $pass = '';

    /**
     * @var array PDO options
     */
    private static $options = array();

    /**
     * Automatic connection to database
     * This is used for dedicated database
     *
     * @return bool
     */
    public static function init()
    {
        return self::connect('mysql', 'localhost', 'database', 'root', '');
    }

    /**
     * Another way of connecting to database
     *
     * @param string $driver            default 'mysql'
     * @param string $host              default 'localhost'
     * @param string|array $database    string dbname | array 'dbname' => dbname, 'dbport' => dbport default 3306
     * @param string $user              default 'root'
     * @param string $password
     *
     * @return bool
     */
    public static function connect($driver, $host, $database, $user, $password, $options = array())
    {
        // check if the connection is already established
        if (self::$init == 1) {
            return false;
        }

        self::$driver = $driver;
        self::$host = $host;

        // check for database if $database var has a port
        if (\is_array($database)) {
            self::$database = $database['dbname'];
            self::$database_port = $database['dbport'];
        } else {
            self::$database = $database;
        }

        self::$user = $user;
        self::$pass = $password;

        // insert developer's selected PDO options
        if (!empty($options)) {
            self::$options = $options;
        } else {
            // default
            self::$options = array(
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
        }
        
        // connect to database
        self::setUpConnection();

        return true;
    }

    private static function setUpConnection()
    {
        // set-up dns
        $dns =
            self::$driver . ':'
            . 'host=' . self::$host
            . ';port=' . self::$database_port
            . ';dbname=' . self::$database;

        // test before connect
        try {
            self::$conn = new PDO($dns, self::$user, self::$pass, self::$options);
        } catch (PDOException $e) {
            // debug
            // die("Database connection failed: " . $e->getMessage());
            die("Database connection failed");
        }

        // prevent the class to be initialize again
        self::$init = 1;
    }
}
