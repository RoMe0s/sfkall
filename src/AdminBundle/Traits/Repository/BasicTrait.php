<?php
namespace AdminBundle\Traits\Repository;
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 2/7/17
 * Time: 11:48 PM
 */
trait BasicTrait
{
    private $query;

    /**
     * @param string $table
     */
    public function init($table) {
        $this->query = $this->createQueryBuilder($table);

        return $this;
    }

    /**
    *
    * @param boolean $status
    * @param string $field
    *
    */
    public function visible($status = true, $field = 'status') {
        $this->query = $this->query
            ->where($field . "=$status")
            ->setParameter('status', $status);

        return $this;
    }

    public function query() {
        return $this->query;
    }

    public function render() {
        $this->query = $this->query->getQuery();

        return $this;
    }

}