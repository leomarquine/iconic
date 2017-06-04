<?php

namespace Marquine\Iconic;

use DOMDocument;
use Illuminate\Contracts\Support\Htmlable;

class Icon implements Htmlable
{
    /**
     * Current icon.
     *
     * @var string
     */
    protected $icon;

    /**
     * Icons repository.
     *
     * @var \Marquine\Iconic\Repository
     */
    protected $repository;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new Icon instance.
     *
     * @param  \Marquine\Iconic\Repository  $repository
     * @param  array  $config
     * @return void
     */
    public function __construct(Repository $repository, $config)
    {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * Set the svg for the icon.
     *
     * @param  string  $name
     * @return $this
     */
    public function make($name)
    {
        $icon = $this->repository->get(
            $name, $this->config['path']
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
        if (! array_key_exists('defaults', $this->config)) {
            return;
        }

        foreach ($this->config['defaults'] as $key => $value) {
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
     * Handle dynamic method calls for icon states.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return $this
     */
    public function __call($method, $arguments)
    {
        $condition = ! empty($arguments) && array_shift($arguments) == false;

        if (! isset($this->config['states'][$method]) || $condition) {
            return $this;
        }

        $value = $this->config['states'][$method];

        if (is_callable($value)) {
            $value($this);
        } else {
            $this->class($value);
        }

        return $this;
    }
}
