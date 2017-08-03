<?php

namespace Marquine\Iconic;

use DOMDocument;
use Illuminate\Contracts\Support\Htmlable;

class Icon implements Htmlable
{
    /**
     * Svg icon.
     *
     * @var \DOMElement
     */
    protected $icon;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected static $config;

    /**
     * Icons repository.
     *
     * @var \Marquine\Iconic\Repository
     */
    protected static $repository;

    /**
     * Icon states.
     *
     * @var array
     */
    protected static $states = [];

    /**
     * Create a new Icon instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! static::$repository) {
            static::repository(new Repository);
        }
    }

    /**
     * Set the icons repository.
     *
     * @param  \Marquine\Iconic\Repository  $repository
     * @return void
     */
    public static function repository(Repository $repository)
    {
        static::$repository = $repository;
    }

    /**
     * Set the configuration.
     *
     * @param  array  $repository
     * @return void
     */
    public static function config(array $config)
    {
        static::$config = $config;
    }

    /**
     * Set the svg for the icon.
     *
     * @param  string  $name
     * @return $this
     */
    public function make($name)
    {
        $icon = static::$repository->get(
            $name, static::$config['path']
        );

        $document = new DOMDocument;
        $document->loadXML($icon);

        $this->icon = $document->getElementsByTagName('svg')->item(0);

        $this->defaults();

        return $this;
    }

    /**
     * Set default values.
     *
     * @return void
     */
    protected function defaults()
    {
        if (! array_key_exists('defaults', static::$config)) {
            return;
        }

        foreach (static::$config['defaults'] as $key => $value) {
            $this->{$key}($value);
        }
    }

    /**
     * Get the svg string.
     *
     * @return string
     */
    public function render()
    {
        return $this->icon->C14N();
    }

    /**
     * Get the svg string.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * Get the svg string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Set an attribute value.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return $this
     */
    public function attribute($attribute, $value)
    {
        $this->icon->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * Set the icon height.
     *
     * @param  mixed  $height
     * @return $this
     */
    public function height($height)
    {
        $this->icon->setAttribute('height', $height);

        return $this;
    }

    /**
     * Set the icon width.
     *
     * @param  mixed  $width
     * @return $this
     */
    public function width($width)
    {
        $this->icon->setAttribute('width', $width);

        return $this;
    }

    /**
     * Set the icon height and width.
     *
     * @param  mixed  $size
     * @return $this
     */
    public function size($size)
    {
        return $this->height($size)->width($size);
    }

    /**
     * Set the icon style.
     *
     * @param  mixed  $style
     * @param  mixed  $value
     * @return $this
     */
    public function style($style, $value = null)
    {
        if (! is_array($style)) {
            $style = [$style => $value];
        }

        array_walk($style, function (&$value, $property) {
            $value = "$property: $value;";
        });

        $this->icon->setAttribute('style', implode(' ', $style));

        return $this;
    }

    /**
     * Set the icon color.
     *
     * @param  string  $color
     * @return $this
     */
    public function color($color)
    {
        $this->icon->setAttribute('fill', $color);

        return $this;
    }

    /**
     * Set the icon class.
     *
     * @param  string  $class
     * @param  bool  $override
     * @return $this
     */
    public function class($class, $override = false)
    {
        $class = $override ? $class : $this->icon->getAttribute('class')." $class";

        $this->icon->setAttribute('class', trim($class));

        return $this;
    }

    /**
     * Set the icon id.
     *
     * @param  string  $id
     * @return $this
     */
    public function id($id)
    {
        $this->icon->setAttribute('id', $id);

        return $this;
    }

    /**
     * Add an icon state.
     *
     * @param  string  $state
     * @param  \Closure  $callback
     * @return void
     */
    public static function state($state, $callback)
    {
        static::$states[$state] = $callback;
    }

    /**
     * Handle dynamic method calls for icon states.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return $this
     */
    public function __call($method, $arguments)
    {
        $condition = ! empty($arguments) && array_shift($arguments) == false;

        if (! isset(static::$states[$method]) || $condition) {
            return $this;
        }

        $callback = static::$states[$method];

        $callback($this);

        return $this;
    }
}
