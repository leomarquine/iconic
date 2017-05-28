<?php

namespace Marquine\Iconic;

use Exception;

class Repository
{
    /**
     * Svg icons cache.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * Get the svg.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    public static function get($name, $path)
    {
        if (! array_key_exists($name, static::$cache)) {
            static::$cache[$name] = static::file(
                rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$name.'.svg'
            );
        }

        return static::$cache[$name];
    }

    /**
     * Read the svg file contents.
     *
     * @param  string  $file
     * @return string
     *
     * @throws \Exception
     */
    protected static function file($file)
    {
        if (is_file($file)) {
            return file_get_contents($file);
        }

        throw new Exception("File '{$file}' was not found.");
    }
}
