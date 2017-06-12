<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/12/17
 * Time: 2:10 PM
 */

namespace MyAdmin\AdminBundle\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * Class DataTableEntities
 * @package MyAdmin\AdminBundle\Annotation
 * @Annotation
 */
class DataTableEntities
{

    /**
     * @var array
     */
    public $entities;

    /**
     * DataTableEntities constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {

        $this->entities = $data['value'];

    }

}