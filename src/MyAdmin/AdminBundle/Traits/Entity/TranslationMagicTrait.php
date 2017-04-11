<?php

namespace MyAdmin\AdminBundle\Traits\Entity;

trait TranslationMagicTrait {

    public function __call($name, $value) {

        $value = array_pop($value);

        // $methods = get_class_methods($this->getTranslations()->first());

        $methods = get_class_methods($this->translate());

        $name = strpos($name, 'get') !== false || strpos($name, 'set') !== false ? $name : 'get' . ucfirst($name);
        
        if(in_array($name, $methods)) {

            $locale = null;

            if(isset($value['locale'])) {

                $locale = $value['locale'];

                unset($value['locale']);

            }

            $value = isset($value['value']) ? $value['value'] : $value;

            // if($locale) {

            //     $localized_data = $this->getTranslations()->get($locale);

            // } else {

            //     $localized_data = $this->getTranslations()->first();

            // }

            // if($localized_data) {

            //     return $localized_data->{$name}($value);

            // }

            return $this->translate($locale)->{$name}($value);

        } else {

            throw new \Exception('Such a method does not exist - ' . $name);

        }
    }

}