<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/12/17
 * Time: 12:20 AM
 */

namespace MyAdmin\AdminBundle\Services;

class EntityManagerService //TODO Вась
{

    protected $repository;

    public function __construct($repository)
    {

        $this->repository = $repository;

    }

}