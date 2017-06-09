<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/9/17
 * Time: 11:51 AM
 */

namespace MyAdmin\AdminBundle\Classes;


use Doctrine\ORM\EntityRepository;
use MyAdmin\AdminBundle\Interfaces\AdminRepositoryInterface;

abstract class AdminAbstractRepository extends EntityRepository implements AdminRepositoryInterface
{

    /**
     * @var string
     */
    public $findMethod = "find";

    /**
     * @var mixed
     */
    public $query;

    /**
     * @var null|string
     */
    public $table = null;

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
    public function visible(bool $status = true, string $field = 'status') {
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

    /**
     * @param $id
     * @return mixed
     */
    public function findWithTranslations(int $id) {
        return $this
            ->init()
            ->query()
            ->leftJoin($this->table.'.translations', 'translations')
            ->addSelect('translations')
            ->where($this->table.'.id=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function getFullListWithTranslations(string $locale) {
        return $this
            ->init()
            ->query()
            ->leftJoin($this->table.'.translations', 'translations', 'WITH', 'translations.locale = :locale')
            ->setParameter('locale', $locale)
            ->addSelect('translations')
            ->getQuery()
            ->getResult();
    }

}