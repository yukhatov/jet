<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 30.01.17
 * Time: 13:02
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class BrandRepository extends EntityRepository
{
    public function findHavingRule()
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('b.rule', 'r');

        return $query->getQuery()->getResult();
    }
}