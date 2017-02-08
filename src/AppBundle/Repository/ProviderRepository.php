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
    /*public function findAllEager()
    {
        $query = $this->createQueryBuilder('p')
            ->join('p.brands', 'b')
            ->join('p.rule', 'r');

        return $query->getQuery()->getResult();
    }*/
}