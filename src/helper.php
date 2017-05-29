<?php

use Marquine\Iconic\Icon;

if (! function_exists('icon')) {
    /**
    * Get svg icon.
    *
    * @param  mixed  $name
    * @return \Marquine\Iconic\Icon
    */
    function icon($name)
    {
        static $icon;

        if ($name instanceof Icon) {
            return $icon = $name;
        }

        return $icon->make($name);
    }
}
