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
    public function getRuledItemsCount($brandId = null)
    {
        $query = $this->createQueryBuilder('b')
            ->join('b.inventoryItems', 'i')
            ->select('count(i.id)');

        $query->where('i.ruleId IS NOT NULL');

        if($brandId)
        {
            $query->andWhere('b.id = :brandId');
            $query->setParameter('brandId', $brandId);
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}