<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.12.16
 * Time: 14:27
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class OrderItemRepository extends EntityRepository
{
    public function findByDateRange($from, $to){
        $sql = 'SELECT 
                    COUNT(DISTINCT jet_orders.id) as orders, 
                    SUM( jet_ordered_items.request_order_quantity ) as items,
                    jet_provider.title 
                FROM `jet_ordered_items` 
                JOIN jet_orders ON order_id=jet_orders.id
                LEFT JOIN jet_inventory ON merchant_sku = sku
                LEFT JOIN jet_provider ON provider_id=jet_provider.id
                WHERE inner_order_placed_date >= :from
                AND inner_order_placed_date <= :to
                GROUP BY provider_id';

        $params = array(
            'from' => $from,
            'to' => $to,
        );

        return $this->getEntityManager()->getConnection()->executeQuery($sql, $params)->fetchAll();

    }
}