<?php

/**
 * @method array select($val = null)
 * @method array insert($val)
 * @method array insertAll($val)
 * @method array execute($val = null)
 * @method array update($val)
 * @method array delete($val)
 */
class Query
{
    private $conn;

    private $stmt;

    /**
     * Constructor
     *
     * @param object $conn  database connection
     * @param string $sql   query string
     */
    public function __construct($conn, $sql)
    {
        $this->conn = $conn;
        $this->stmt = $this->conn->prepare($sql);
    }

    /**
     * Select function
     *
     * @param array ...$val
     * @return array
     */
    public function select($val = null)
    {
        $rows = [];

        try {
            $this->stmt->execute($val);

            while ($row = $this->stmt->fetch()) {
                $rows[] = $row;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $rows;
    }

    /**
     * Insert function
     *
     * @param array $val
     * @return array
     */
    public function insert($val)
    {
        $info = false;

        try {
            $this->stmt->execute($val);
            $info['insert_id'] = $this->conn->lastInsertId();
        } catch (\Throwable $th) {
            throw $th;
        }

        return $info;
    }

    /**
     * InsertAll function
     *
     * @param array $val
     * @return array
     */
    public function insertAll($val)
    {
        $info = false;
        
        try {
            foreach ($val as $v) {
                $this->stmt->execute($v);
                $info['insert_id'][] = $this->conn->lastInsertId();
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $info;
    }

    /**
     * Execute function
     * use this for single execute with no any return exept affected_rows
     *
     * @param array $val
     * @return array        key = affected_rows
     */
    public function execute($val = null)
    {
        $info = array('affected_rows' => false);

        try {
            $this->stmt->execute($val);
            $info['affected_rows'] = $this->stmt->rowCount();
        } catch (\Throwable $th) {
            throw $th;
        }

        return $info;
    }

    /**
     * Update function
     *
     * @param array $val
     * @return array        key = affected_rows
     */
    public function update($val)
    {
        return self::execute($val);
    }

    /**
     * Delete function
     *
     * @param array $val
     * @return array        key = affected_rows
     */
    public function delete($val)
    {
        return self::execute($val);
    }
}
