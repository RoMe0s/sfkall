<?php

/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/12/17
 * Time: 12:44 AM
 */
namespace MyAdmin\AdminBundle\Annotation\Driver;

use Doctrine\Common\Annotations\Reader;
use MyAdmin\AdminBundle\Annotation\DataTableEntities;
use MyAdmin\AdminBundle\Annotation\DefaultValue;

/**
 * Class DefaultValueDriver
 * @package MyAdmin\AdminBundle\Annotation\Driver
 */
class DefaultValueDriver
{

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * DefaultValueDriver constructor.
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param $object
     * @param array $fields
     * @return mixed
     */
    public function process($object, array $fields) {

        $class = get_class($object);

        $entities = array($class);

        $annotation = $this->reader->getClassAnnotation(new \ReflectionClass($class), DataTableEntities::class);

        if($annotation) {

            $path = explode("\\", $class);

            unset($path[count($path) - 1]);

            $path = implode("\\", $path) . "\\";

            foreach($annotation->entities as $entity) {

                $entities[] = $path . $entity;

            }

        }

        foreach ($fields as $field) {

            $annotation = null;

            foreach($entities as $entity) {

                if(property_exists($entity, $field)) { //current class property

                    $annotation = $this->reader->getPropertyAnnotation(new \ReflectionProperty($entity, $field), DefaultValue::class);

                    break;

                }

            }

            if($annotation !== null) {

                $object->{"set" . ucfirst($field)}($annotation->getValue());

            }

        }

        return $object;

    }

}