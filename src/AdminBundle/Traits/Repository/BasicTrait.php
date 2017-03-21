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

    private $table = null;

    /**
     * @return $this
     */
    public function init() {

        $this->table = $this->getClassMetadata($this->getEntityName())->getTableName();

        $this->query = $this->createQueryBuilder($this->table);

        return $this;
    }

    /**
     * @param bool $status
     * @param string $field
     * @return $this
     */
    public function visible($status = true, $field = 'status') {
        $this->query = $this->query
            ->where("$field=:status")
            ->setParameter('status', $status);

        return $this;
    }

    /**
     * @return mixed
     */
    public function query() {
        return $this->query;
    }

}