<?php


namespace App\Core;


use PDO;
use PDOStatement;

class DB
{
    private static $host = '127.0.0.1';
    private static $user = 'root';
    private static $pass = '';
    private static $database = 'dbgame';

    private $attributes = [];

    /**
     * @var PDO
     */
    private $db;

    /**
     * @var string
     */
    private $error;

    /**
     * @var PDOStatement
     */
    private $statement;

    /**
     * DB constructor.
     * @param null $query
     * @throws \Exception
     */
    public function __construct($query = null)
    {
        if ($this->db !== null) return;

        $dsn = sprintf("mysql:host=%s;dbname=%s", self::$host, self::$database);
        try {
            $this->db = new \PDO($dsn, self::$user, self::$pass, [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            throw new \Exception($e);
        } finally {
            if ($query !== null) $this->prepare($query);
        }
    }

    /**
     * @return PDO
     */
    public function PDO() {
        return $this->db;
    }

    public function queryString() {
        return $this->statement->queryString;
    }

    public function debug() {
        return $this->statement->debugDumpParams();
    }

    /**
     * DB::make($query)->execute($data)->all();
     * @param $query
     * @return static
     * @throws \Exception
     */
    public static function make($query) {
        $instance = new static();
        $instance->prepare($query);
        return $instance;
    }

    /**
     * @param $query
     * @return $this
     * @throws \Exception
     */
    public function query($query) {
        $this->prepare($query);
        return $this;
    }


    /**
     * @param $query
     * @throws \Exception
     */
    public function prepare($query) {
        if (! $this->db instanceof PDO) throw new \Exception("[DB] Invalid instance, given: ". get_class($this->db));
        $this->statement = $this->db->prepare($query);
    }

    /**
     * @param $key
     * @param $value
     * @param null $type
     */
    public function bindParam($key, $value, $type = null) {
        if ($type === null) {
            if (is_int($type)) {
                $this->statement->bindParam($key, $value, PDO::PARAM_INT);
            } elseif (is_bool($type)) {
                $this->statement->bindParam($key, $value, PDO::PARAM_BOOL);
            } elseif (is_null($type)) {
                $this->statement->bindParam($key, $value, PDO::PARAM_NULL);
            } elseif (is_string($type)) {
                $this->statement->bindParam($key, $value, PDO::PARAM_STR);
            }
        }
    }

    /**
     * @param array $params
     */
    private function bindParams($params = []) {
        $params = (!empty($params) && is_array($params)) ? $params : $this->attributes;
        foreach ($params as $param => &$val) {
            $this->bindParam(':' . $param, $val);
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function execute($data = []) {
        if (!empty($data)) {
            $this->statement->execute($data);
            return $this;
        }

        $this->bindParams();
        $this->statement->execute();
        return $this;
    }

    /**
     * @return PDOStatement
     */
    public function statement() {
        return $this->statement;
    }

    /**
     * @param null $type
     * @return mixed
     */
    public function first($type = null) {
        $this->execute();
        $type = !empty($type) ? $type : PDO::FETCH_OBJ;
        return $this->statement->fetch($type);
    }

    /**
     * @param null $type
     * @return array
     */
    public function all($type = null) {
        $this->execute();
        $type = !empty($type) ? $type : PDO::FETCH_OBJ;
        return $this->statement->fetchAll($type);
    }

    /**
     * @return int
     */
    public function count() {
        return $this->statement->rowCount();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function lastInsertId($name = '') {
        return $this->db->lastInsertId($name);
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]) OR property_exists($this, $name);
    }

    public function __set($key, $val) {
        $this->attributes[$key] = $val;
    }

    public function __get($key) {
        return $this->attributes[$key];
    }

    public function __call($name, $arguments)
    {
        if ($this->db instanceof \PDO && method_exists($this->db, $name)) {
            return call_user_func_array([$this->db, $name], $arguments);
        } elseif ($this->statement instanceof \PDOStatement && method_exists($this->statement, $name)) {
            return call_user_func_array([$this->statement, $name], $arguments);
        }

        return null;
    }

    public function __destruct()
    {
        if ($this->error !== null) throw new \Exception("[DB] " . $this->error);
    }

}