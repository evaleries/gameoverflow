<?php


namespace App\Core;


/**
 * Template rendering sederhana menggunakan RegEx, preg_replace.
 * Terinspirasi dari Blade.
 * Class View
 * @package App\Core
 */
class View {

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private static $sharedAttributes = [];

    /**
     * @var bool|false|string
     */
    private $template;


    /**
     * View constructor.
     * @param $fileName
     * @param array $attributes
     * @throws \Exception
     */
    public function __construct($fileName, $attributes = [])
    {
        $this->with($attributes);
        $this->template = $this->loadFile($fileName);

        if (! $this->template) {
            throw new \Exception("[View] Template tidak valid: ". $fileName);
        }
    }

    /**
     * @param $fileName
     * @param array $attributes
     * @return static
     * @throws \Exception
     */
    public static function make($fileName, $attributes = []) {
        return new static($fileName, $attributes);
    }

    /**
     * @param null|string|array $attributes
     * @param null|string $value
     */
    public static function shared($attributes = null, $value = null)
    {
        if (is_string($attributes)) {
            self::$sharedAttributes[$attributes] = $value;
            return;
        }

        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                self::$sharedAttributes[$key] = $val;
            }
        }
    }

    public static function getSharedAttributes($attributesName = null)
    {
        if ($attributesName === null) {
            return self::$sharedAttributes;
        }

        return self::$sharedAttributes[$attributesName];
    }

    /**
     * @param $fileName
     * @return bool|string
     */
    public static function isExist($fileName)
    {
        return self::resolveAbsolutePath($fileName);
    }

    /**
     * @param $fileName
     * @return bool|string
     */
    private static function resolveAbsolutePath($fileName)
    {
        $fileName = str_replace('.', '/', $fileName);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName .= (empty($extension)) ? '.php' : '.' . $extension;

        $absolutePath = VIEW_PATH . DS . $fileName;
        return (file_exists($absolutePath)) ? $absolutePath : false;
    }

    /**
     * @param $fileName
     * @return bool|false|string
     */
    private function loadFile($fileName)
    {
        $absolutePath = self::resolveAbsolutePath($fileName);
        if (! $absolutePath)
            return false;

        extract(array_merge($this->attributes, self::$sharedAttributes), EXTR_SKIP);

        ob_start();
        include_once $absolutePath;
        $template = ob_get_clean();
        ob_end_clean();

        return $template;
    }

    /**
     * Replace {{test}} & {!! $test }} dengan isi variable $test
     */
    private function replaceAttributes() {
        $this->compilePattern('~{{(.+?)}}~m');
        $this->compilePattern('~{!!(.+?)!!}~m', false);
    }

    /**
     * @param $pattern
     * @param bool $safe
     */
    private function compilePattern($pattern, $safe = true)
    {
        if (preg_match_all($pattern, $this->template, $matches)) {
            if (! isset($matches[0])) return;
            foreach ($matches[0] as $vars) {
                $cleanVar = str_replace('{{', '', $vars);
                $cleanVar = trim(str_replace('}}', '', $cleanVar));
                if (isset($this->attributes[$cleanVar])) {
                    $replaceWith = ($safe)
                        ? $this->safeEcho($this->attributes[$cleanVar])
                        : $this->unsafeEcho($this->attributes[$cleanVar]);
                    $this->template = preg_replace('~' . $vars . '~', $replaceWith, $this->template);
                }
            }
        }
    }

    /**
     * Penggunaan {{ $value }} agar terhindar dari XSS
     * @param $value
     * @return string
     */
    private function safeEcho($value) {
        $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    private function unsafeEcho($value) {
        return trim($value);
    }

    /**
     * @return bool|false|string
     */
    public function render()
    {
        $this->replaceAttributes();

        return $this->template;
    }

    /**
     *
     */
    public function output()
    {
        $this->replaceAttributes();

//        ob_start(); ob_end_clean();

        print($this->template);
    }

    /**
     * @return array
     */
    public function dumpData()
    {
        return array_merge($this->attributes, self::$sharedAttributes);
    }

    /**
     * @param array $data
     * @param null $val
     */
    public function with($data = [], $val = null)
    {
        if (!is_array($data) && !empty($val)) {
            $this->__set($data, $val);
            return;
        }

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $this->__set($key, $val);
            }
        }
    }

    /**
     * Magic method untuk set attribute
     * e.g: $view->a = 123;
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    /**
     * Magic method untuk get attribute
     * e.g: $view->a;
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        return $this->attributes[$key];
    }

    /**
     * Magic method digunakan apabila object class ini dikonversi menjadi string atau dipanggil melalui var_dump(View);
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

}