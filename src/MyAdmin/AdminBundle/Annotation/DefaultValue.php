<?php

/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/12/17
 * Time: 12:33 AM
 */

namespace MyAdmin\AdminBundle\Annotation;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;

/**
 * @Annotation
 */
class DefaultValue
{

    /**
     * @var string
     */
    public $value;

    /**
     * DefaultValue constructor.
     * @param array $data
     */
    function __construct(array $data)
    {

        if(!isset($data['translate']) || $data['translate'] !== FALSE) {

            $translator = get_translator();

            $data['value'] = $translator->trans($data['value']);

        }

        $this->value = $data['value'];

    }

    /**
     * @return string
     */
    public function getValue() {

        return $this->value;

    }

}