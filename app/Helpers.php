<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/9/17
 * Time: 11:18 AM
 */
if(! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        array_map(function ($x) {
            dump($x);
        }, func_get_args());

        die(1);
    }
}