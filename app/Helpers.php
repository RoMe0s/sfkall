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

if(! function_exists('default_locale')) {

    /**
     * @return string
     */
    function default_locale() {

        return "ru";

    }

}

if(! function_exists('get_translator')) {

    /**
     * @param string $locale
     * @return \Symfony\Component\Translation\Translator
     */
    function get_translator(string $locale = "") {

        $locale = !empty($locale) ? $locale : default_locale();

        $path = __DIR__ . "/../src/MyAdmin/AdminBundle/Resources/translations/messages." . $locale . ".yml";

        if(!file_exists($path)) {

            throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException($path . " - file not found");

        }

        $translator = new \Symfony\Component\Translation\Translator($locale);

        $translator->addLoader("yaml", new \Symfony\Component\Translation\Loader\YamlFileLoader());

        $translator->addResource("yaml", $path, $locale);

        return $translator;

    }

}