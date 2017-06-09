<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/9/17
 * Time: 11:49 AM
 */

namespace MyAdmin\AdminBundle\Interfaces;


interface AdminRepositoryInterface
{

    /**
     * @return $this
     */
    public function init();

    /**
     * @param bool $status
     * @param string $field
     * @return mixed
     */
    public function visible(bool $status = true, string $field = 'status');

    /**
     * @return mixed
     */
    public function query();

}