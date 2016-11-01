<?php

if (! function_exists('is_lucky')) {
    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param  array  $array
     * @return array
     */
    function is_lucky($percent)
    {
        if (rand(1, 100) <= $percent) {
            return true;
        } else {
            return false;
        }
    }
}
