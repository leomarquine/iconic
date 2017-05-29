<?php

namespace Marquine\Iconic;

class Icon
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
        $this->icon = $this->repository->get(
            $name, $this->config['path']
        );

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
        return $this->icon;
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
        $this->icon = preg_replace(
            '/(?<=\sheight=")(.*?)(?=")/', $height, $this->icon
        );

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
        $this->icon = preg_replace(
            '/(?<=\swidth=")(.*?)(?=")/', $width, $this->icon
        );

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
     * Set the icon color.
     *
     * @param  string  $color
     * @return $this
     */
    public function color($color)
    {
        $this->icon = preg_replace(
            '/(?<=\sfill=")(.*?)(?=")/', $color, $this->icon
        );

        return $this;
    }
}
