<?php

namespace AdminBundle\Repository;

use AdminBundle\Traits\Repository\BasicTrait;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{

    use BasicTrait;

    /**
     * @param $locale
     * @return mixed
     */
    public function getFullList($locale) {
        return $this
            ->init()
            ->query()
            ->leftJoin($this->table.'.translations', 'translations', 'WITH', 'translations.locale = :locale')
            ->setParameter('locale', $locale)
            ->addSelect('translations')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findWithTranslations($id) {
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

}
