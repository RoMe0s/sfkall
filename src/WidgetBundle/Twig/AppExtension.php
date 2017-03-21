<?php

/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 17.03.17
 * Time: 23:15
 */

namespace WidgetBundle\Twig;

class AppExtension extends \Twig_Extension
{

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction(
                'widget',
                array($this, 'load'),
                array('is_safe' => array('html'))
            )
        );
    }

    public function load($widget, $id) {

        return '<h1>Виджет</h1>';

    }

}