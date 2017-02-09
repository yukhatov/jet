<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 03.02.17
 * Time: 11:02
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ProviderRepository extends EntityRepository
{
    public function getRuledItemsCount($providerId = null)
    {
        $query = $this->createQueryBuilder('p')
            ->join('p.inventoryItems', 'i')
            ->select('count(i.id)');

        $query->where('i.ruleId IS NOT NULL');

        if($providerId)
        {
            $query->andWhere('p.id = :providerId');
            $query->setParameter('providerId', $providerId);
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}