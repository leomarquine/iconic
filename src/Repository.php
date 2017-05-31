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
    protected $cache = [];

    /**
     * Get the svg.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    public function get($name, $path)
    {
        if (! array_key_exists($name, $this->cache)) {
            $this->cache[$name] = $this->file(
                rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.str_replace('.', DIRECTORY_SEPARATOR, $name).'.svg'
            );
        }

        return $this->cache[$name];
    }

    /**
     * Read the svg file contents.
     *
     * @param  string  $file
     * @return string
     *
     * @throws \Exception
     */
    protected function file($file)
    {
        if (is_file($file)) {
            return file_get_contents($file);
        }

        throw new Exception("File '{$file}' was not found.");
    }
}
