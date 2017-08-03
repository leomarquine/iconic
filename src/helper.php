<?php

use Marquine\Iconic\Icon;

if (! function_exists('icon')) {
    /**
    * Get svg icon.
    *
    * @param  string  $icon
    * @return \Marquine\Iconic\Icon
    */
    function icon($icon)
    {
        return (new Icon)->make($icon);
    }
}
