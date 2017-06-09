<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/9/17
 * Time: 11:58 AM
 */

namespace MyAdmin\AdminBundle\Classes;


use MyAdmin\AdminBundle\Interfaces\AdminEntityInterface;

abstract class AdminAbstractEntity implements AdminEntityInterface
{

    /**
     * @param $name
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $value) {

        $value = array_pop($value);

        if(method_exists($this, 'translate')) {

            $methods = get_class_methods($this->translate());

            $name = strpos($name, 'get') !== false || strpos($name, 'set') !== false ? $name : 'get' . ucfirst($name);

            if (in_array($name, $methods)) {

                $locale = null;

                if (isset($value['locale'])) {

                    $locale = $value['locale'];

                    unset($value['locale']);

                }

                $value = isset($value['value']) ? $value['value'] : $value;

                return $this->translate($locale)->{$name}($value);

            } else {

                throw new \Exception('Such a method does not exist - ' . $name);

            }

        }
    }

}