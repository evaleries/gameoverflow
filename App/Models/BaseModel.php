<?php


namespace App\Models;


use App\Core\DB;
use App\Core\Route;
use Exception;
use PDO;

/**
 * Class BaseModel
 * @package app\models
 */
class BaseModel implements CrudContracts
{
    protected $primaryKey;

    protected $primaryType = 'int';

    protected $foreignAttributes = [];

    protected $attributes = [];

    protected $fillable = [];

    protected $hidden = [];

    protected $appends = [];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DB
     */
    protected static $db;

    public function __construct()
    {
        if (! self::$db instanceof DB) {
            self::$db = service(\App\Core\DB::class);
        }

    }

    public static function PDO() {
        return self::$db->PDO();
    }

    public static function DB() {
        return self::$db;
    }

    /**
     * @return int
     */
    public function getPrimaryKey()
    {
        return ($this->primaryType === 'int') ? intval($this->primaryKey) : $this->primaryKey;
    }

    /**
     * @param $key
     */
    private function setPrimaryKey($key)
    {
        if (! $key) throw new \InvalidArgumentException("Invalid parameter for primaryKey");
        $this->primaryKey = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return 'id';
    }

    /**
     * @param $required
     * @param $data
     * @return mixed
     */
    protected static function prepareFillable($required, $data)
    {
        foreach ($data as $key => $val) {
            if (! in_array($key, $required)) unset($data[$key]);
        }

        return $data;
    }

    /**
     * @param $data
     * @return array|string
     */
    protected static function transformParam($data) {

        if (is_string($data)) {
            return startsWith($data, '%') ? '%:' . str_replace('%', '', $data) . '%' : ':' . $data;
        }

        foreach (array_keys($data) as $key) {
            $data[] = startsWith($key, '%') ? '%:'. str_replace('%', '', $key) . '%' : ':' . $key;
            unset($data[$key]);
        }

        return $data;
    }

    /**
     * Morph class sederhana untuk mapping ke class model.
     * @see https://catchmetech.com/en/post/94/how-to-create-an-orm-framework-in-pure-php-orm-creation-tutorial
     * @param array $object
     * @return object
     */
    public static function morph($object)
    {
        $class = self::reflect();
        $instance = $class->newInstance();

        $fillable = self::propAccessible($class, 'fillable');
        $attributes = self::propAccessible($class, 'attributes');
        $primaryColumn = self::methodAccessible($class, 'getKey')->invoke($instance);
        $validAttributes = self::prepareFillable($fillable->getValue($instance), $object);

        // fill attributes & set primary key
        $attributes->setValue($instance, $validAttributes);
        self::methodAccessible($class, 'setPrimaryKey')->invoke($instance, $object[$primaryColumn]);

        // fill foreign attributes
        if ($class->hasProperty('foreignAttributes')) {
            $foreignAttributes = self::propAccessible($class, 'foreignAttributes');
            $attributeKeys = array_keys($validAttributes);
            $tempForeign = [];
            foreach ($object as $key => $val) {
                if (! in_array($key, $attributeKeys)) {
                    $tempForeign[$key] = $val;
                }
            }
            $foreignAttributes->setValue($instance, $tempForeign);
        }

        $instance->initialize();

        return $instance;
    }

    /**
     * @return \ReflectionClass
     */
    private static function reflect() {
        try {
            $class = new \ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            exit($e->getMessage());
        } finally {
            return $class;
        }
    }

    /**
     * @param \ReflectionClass $model
     * @param $property
     * @return \ReflectionProperty|bool
     */
    private static function propAccessible(\ReflectionClass $model, $property)
    {
        if (! $model->hasProperty($property)) return false;

        $prop = false;
        try {
            $prop = $model->getProperty($property);
            $prop->setAccessible(true);
        } catch (\ReflectionException $e) {
            throw new \BadMethodCallException("[BaseModel] {$e->getMessage()}", 50);
        } finally {
            return $prop;
        }
    }

    /**
     * @param \ReflectionClass $model
     * @param object $instance
     * @param $prop
     * @return mixed
     */
    private static function resolveProp(\ReflectionClass $model, $instance, $prop) {
        return self::propAccessible($model, $prop)->getValue($instance);
    }

    /**
     * @param \ReflectionClass $model
     * @param $method
     * @return bool|\ReflectionMethod
     */
    private static function methodAccessible(\ReflectionClass $model, $method)
    {
        if (! $model->hasMethod($method)) return false;

        $met = false;
        try {
            $met = $model->getMethod($method);
            if (! $met->isPublic())
                $met->setAccessible(true);
        } catch (\ReflectionException $e) {
            throw new \BadMethodCallException("[BaseModel] {$e->getMessage()}");
        } finally {
            return $met;
        }
    }

    /**
     * @return bool
     */
    public static function debug()
    {
        return self::$db->debug();
    }

    /**
     * @param $query
     * @param array $data
     * @param int $resultType
     * @return array
     * @throws \Exception
     */
    public static function raw($query, $data = [], $resultType = 5)
    {
        return self::$db->query($query)->execute($data)->all($resultType);
    }

    /**
     * @param $query
     * @param array $data
     * @param int $resultType
     * @return mixed
     * @throws \Exception
     */
    public static function rawFirst($query, $data = [], $resultType = 5) {
        return self::$db->query($query)->execute($data)->first($resultType);
    }

    /**
     * @param $query
     * @param array $data
     * @param int $resultType
     * @return object|null
     * @throws Exception
     */
    public static function morphRaw($query, $data = [], $resultType = 2) {
        try {
            $result = self::rawFirst($query, $data, $resultType);
            if (! $result) {
                // return [];
               throw new Exception("Resource not found", 404);
            }

            return self::morph($result);
        } catch (Exception $e) {
            Route::error(404, $e->getMessage());
        }
    }

    public static function morphManyRaw($query, $data = [], $resultType = 2) {

        $result = self::raw($query, $data, $resultType);
        if (! $result) {
            return [];
//            throw new Exception("Resource not found", 404);
        }

        $instances = [];
        foreach ($result as $item) {
            $instances[] = self::morph($item);
        }

        return $instances;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param bool $morph
     * @return array
     * @throws Exception
     */
    public static function all($limit = 100, $offset = 0, $morph = true)
    {
        $class = self::reflect();
        $instance = $class->newInstance();

        $table = self::resolveProp($class, $instance, 'table');
        if ($limit == -1) {
            $query = sprintf("SELECT * FROM %s", $table);
        } else {
            $query = sprintf("SELECT * FROM %s LIMIT %d, %d", $table, intval($offset), intval($limit));
        }
        
        $result = self::$db->query($query)->all(PDO::FETCH_ASSOC);
        if (! $result) {
            return [];
        }

        if (! $morph) {
            return $result;
        }

        $instances = [];
        foreach ($result as $res) {
            $instances[] = self::morph($res);
        }

        return $instances;
    }

    /**
     * @see https://www.malasngoding.com/membuat-paging-dengan-php-dan-mysql/
     * @param int $page
     * @param int $perPage
     * @param array $data
     * @return object
     * @throws Exception
     */
    public static function paginate($page = 1, $perPage = 10, $options = [])
    {
        $class = self::reflect();
        $instance = $class->newInstance();

        $page = intval($page);
        $perPage = intval($perPage);
        $start = ($page >= 1) ? ($page * $perPage) - $perPage : 0;

        $query = !empty($options['total_query']) 
                ? $options['total_query'] 
                : "SELECT * FROM ". self::resolveProp($class, $instance, 'table');

        $data = isset($options['data']) 
                ? $options['data'] 
                : self::all($perPage, $start);

        $total = (!empty($options['param_query'])) 
                ?  intval(self::$db->query($query)->execute($options['param_query'])->count())
                : intval(self::$db->query($query)->execute()->count());

        if (! $total || $data === false) {
            throw new Exception(sprintf("[Pagination - %s] invalid total OR data.", $class->getShortName()));
        }

        $pages = ceil($total / $perPage);

        return (object) [
            'data' => $data,
            'pages' => $pages,
            'hasNext' => $page < $pages && $page >= 1,
            'hasPrev' => $page >= $pages && $page >= 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1
        ];
    }

    /**
     * @param array $data
     * @return bool|object
     * @throws Exception
     */
    public function create($data = [])
    {
        $data = ! empty($data) ? $data : $this->attributes;
        $prepareFillable = self::prepareFillable($this->fillable, $data);

        if (in_array('created_at', $this->attributes)) $data['created_at'] = now();

        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', array_keys($prepareFillable)),
            implode(', ', self::transformParam($prepareFillable))
        );

        try {
            self::$db->query($query)->execute($data);
            $this->setPrimaryKey(self::$db->PDO()->lastInsertId());
        } catch (\PDOException $e) {
            if ($e->getCode() == 1062) {
                return false;
            } else {
                throw $e;
            }
        }

        $this->attributes = array_replace($this->attributes, $data);

        return (self::$db->PDO()->lastInsertId() !== false) ? $this : false;
    }

    /**
     * Update data yang sudah ada
     * @param array $data
     * @return BaseModel|bool
     * @throws \Exception
     */
    public function update($data = [])
    {
        $data = !empty($data) ? $data : $this->attributes;

        if (in_array('updated_at', $this->attributes)) $data['updated_at'] = now();

        if (empty($this->primaryKey)) {
            throw new \Exception("[". get_called_class() ."] Mencoba mengupdate data tanpa primary key!");
        }

        $preparedFillable = self::prepareFillable($this->fillable, $data);
        $transformedParam = self::transformParam($preparedFillable);

        $sets = [];
        foreach(array_combine(array_keys($preparedFillable), $transformedParam) as $key => $val) {
            array_push($sets, $key . ' = ' . $val);
        }

        $query = sprintf("UPDATE %s SET %s WHERE %s = %s",
            $this->table,
            implode(', ', $sets),
            $this->getKey(),
            $this->getPrimaryKey()
        );


        $result = [];
        try {
            $result = self::$db->query($query)->execute($data);
        } catch (\PDOException $e) {
            if ($e->getCode() == 1062) {
                return false;
            } else {
                throw $e;
            }
        }

        $this->attributes = array_replace($this->attributes, $data);

        return $this;
    }

    /**
     * @return BaseModel|bool
     * @throws \Exception
     */
    public function delete()
    {
        if (empty($this->primaryKey)) return false;
        $query = sprintf("DELETE FROM %s WHERE %s = %s", $this->table, $this->getKey(), $this->primaryKey);

        try {
            self::$db->query($query)->execute();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            } else {
                throw $e;
            }
        }

        return (! empty($data)) ? self::$db->rowCount() : $this;
    }

    /**
     * @param array $options
     * @param string $operator
     * @return array
     * @throws \Exception
     */
    public static function find($options = [], $operator = 'AND')
    {
        $class = self::reflect();
        $instance = $class->newInstance();
        $result = [];
        $data = [];
        $whereClause = [];

        if (!empty($options)) {
            foreach(array_combine(array_keys($options), self::transformParam($options)) as $key => &$val) {
                if (startsWith(trim($key), '%')) {
                    $cleanKey = str_replace('%', '', $key);
                    array_push($whereClause, $cleanKey . ' LIKE ?');
                    $data[] = $options[$key];
                } else {
                    array_push($whereClause, $key . ' = '. $val);
                    $data[$key] = $options[$key];
                }
            }
        }

        $query = sprintf("SELECT * FROM %s WHERE (%s)",
            self::resolveProp($class, $instance, 'table'),
            empty($options) ? 1 : implode(' '. $operator .' ', $whereClause)
        );

        $raw = self::$db->query($query)->execute($data)->all(PDO::FETCH_ASSOC);
        foreach ($raw as $rawRow) {
            $result[] = self::morph($rawRow);
        }

        return $result;
    }

    /**
     * @param array $options
     * @param string $operator
     * @return array|mixed
     * @throws \Exception
     */
    public static function first($options = [], $operator = 'AND')
    {
        $res = self::find($options, $operator);
        return (is_countable($res) && count($res) > 0) ? $res[0] : $res;
    }

    /**
     * @param array $options
     * @param string $operator
     * @return array|mixed|void
     * @throws \Exception
     */
    public static function firstOrFail($options = [], $operator = 'AND')
    {
        $res = self::first($options, $operator);
        return ! $res ? Route::error(404, 'Model not found') : $res;
    }

    public function __set($name, $value)
    {
        $setters = 'set' . ucwords($name);
        if (method_exists($this, $setters)) {
            call_user_func([$this, $setters], $value);
        } else {
            $this->attributes[$name] = $value;
        }
    }

    public function __get($name)
    {
        $getter = $this->getFunctionName($name, 'get');
        if ($this->__isset($name) && !in_array($name, $this->dates)) {
            if (method_exists($this, $getter)) return $this->callMethod($this, $method);
            
            return $this->attributes[$name];
        } elseif (isset($this->foreignAttributes[$name])) {
            return $this->foreignAttributes[$name];
        } elseif (in_array($name, $this->dates) && isset($this->attributes[$name])) {
            if (method_exists($this, $getter)) return $this->callMethod($this, $method);

            return $this->getDate($this->attributes[$name]);
        } elseif ($name == $this->getKey() && $this->getPrimaryKey() !== null) {
            return $this->getPrimaryKey();
        }

        return null;
    }

    /**
     * @param $instance
     * @param $method
     * @return bool|mixed
     */
    protected function callMethod($instance, $method)
    {
        return (method_exists($instance, $method)) ? call_user_func([$instance, $method]) : false;
    }

    /**
     * @param $name
     * @param string $prefix
     * @return string
     */
    protected function getFunctionName($name, $prefix = 'get')
    {
        return $prefix . ucwords(str_replace('_', '', $name));
    }

    /**
     * @param $instance
     * @param $name
     * @return bool|mixed
     */
    protected function callGetters($instance, $name) {
        return $this->callMethod($instance, $this->getFunctionName($name, 'get'));
    }

    /**
     * @param $instance
     * @param $name
     * @return bool|mixed
     */
    protected function callSetters($instance, $name) {
        return $this->callMethod($instance, $this->getFunctionName($name, 'set'));
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __call($name, $arguments)
    {
        if (self::$db instanceof \PDO && method_exists(self::$db, $name)) {
            return call_user_func_array([self::$db, $name], $arguments);
        }

        $getter = $this->getFunctionName($name, 'get');
        if (method_exists($this, $getter)) {
            return call_user_func([$this, $getter]);
        }

        return null;
    }

    /**
     * @param $date
     * @param string $format
     * @return string
     * @throws \Exception
     */
    protected function getDate($date, $format = 'j F Y')
    {
        try {
            return (new \DateTime($date))->format($format);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Export attribute.
     * @return array
     */
    public function exposeAttribute()
    {
        $attr = [];

        if ($this->primaryKey !== null) {
            $attr[$this->getKey()] = $this->getPrimaryKey();
        }

        foreach ($this->attributes as $key => $val) {
            if (! in_array($key, $this->hidden)) {
                $getters = 'get' . ucwords($key);
                if (method_exists($this, $getters)) {
                    $attr[$key] = call_user_func([$this, $getters]);
                    continue;
                }

                $attr[$key] = $val;
            }
        }

        foreach ($this->appends as $method) {
            if (method_exists($this, $method) && !isset($attr[$method])) {
                $attr[$method] = call_user_func([$this, $method]);
            }
        }

        if (!empty($this->foreignAttributes)) $attr = array_merge($attr, $this->foreignAttributes);

        return $attr;
    }

    public function __toString()
    {
        ob_start();

        var_dump($this->exposeAttribute());
        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}