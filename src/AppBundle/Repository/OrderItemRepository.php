<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.12.16
 * Time: 14:27
 */
namespace AppBundle\Repository;

use AppBundle\Entity\Order;
use AppBundle\Entity\OrderStatus;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class OrderItemRepository extends EntityRepository
{
    public function findSummaryByDateRange($from, $to){
        $sql = 'SELECT 
                    SUM( jet_ordered_items.request_order_quantity ) as items,
                    jet_provider.title 
                FROM `jet_ordered_items` 
                JOIN jet_orders ON order_id=jet_orders.id
                LEFT JOIN jet_inventory ON merchant_sku = sku
                LEFT JOIN jet_provider ON provider_id=jet_provider.id
                WHERE inner_order_placed_date >= :from
                AND inner_order_placed_date <= :to
                AND NOT((status = "complete" AND (shipment_tracking_number = "" OR shipment_tracking_number IS NULL)) OR status = "canceled")
                GROUP BY provider_id';

        $params = array(
            'from' => $from,
            'to' => $to,
        );

        return $this->getEntityManager()->getConnection()->executeQuery($sql, $params)->fetchAll();
    }

    public function getTotalCount(){
        $query = $this->createQueryBuilder('o')
            ->join('o.order', 'ord')
            ->select('count(o.id)');

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalCountByParams($params)
    {
        $query = $this->getQueryByParams($params)
            ->join('o.order', 'ord')
            ->select('count(o.id)');

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    public function getOrdersCountByDateRange($fromDate, $toDate){
        $query = $this->createQueryBuilder('oi')
            ->join('oi.order', 'd')
            ->select('count(DISTINCT d.id)');

        $query->andWhere('d.inner_order_placed_date >= :from');
        $query->andWhere('d.inner_order_placed_date <= :to');
        $query->setParameter('from', $fromDate);
        $query->setParameter('to', $toDate);

        $query = $this->addStatusFilter($query);

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    public function findByParamsSerialized($params)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('items'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($this->findByParams($params), 'json'));

        return $content;
    }

    public function findByParams($params){
        $query = $this->getQueryByParams($params);

        if(isset($params['start']) and isset($params['length'])){
            $query->setFirstResult( $params['start'] )
                ->setMaxResults( $params['length'] );
        }

        return $query->getQuery()
            ->getResult();
    }

    private function getQueryByParams($params)
    {
        $query = $this->createQueryBuilder('o')
            ->join('o.order', 'd');

        $query = $this->addStatusFilter($query);

        if(isset($params['fromDate']) and isset($params['toDate'])){
            $fromDate = strtotime($params['fromDate']);
            $toDate = strtotime($params['toDate']);

            if($params['fromDate'] == $params['toDate']){
                $toDate += 86400;
            }

            $query->andWhere('d.inner_order_placed_date >= :from');
            $query->andWhere('d.inner_order_placed_date <= :to');
            $query->setParameter('from', $fromDate);
            $query->setParameter('to', $toDate);
        }

        if(!empty($params['order'][0]))
        {
            $column = $this->getColumns()[$params['order'][0]['column']];
            $order = $params['order'][0]['dir'];

            $query->orderBy($column, $order);
        }

        return $query;
    }

    /*
     * STATUS_CANCELED and STATUS_COMPLETE with no TN not needed
     * */
    private function addStatusFilter($query)
    {
        $query->andWhere('NOT ((d.status = :statusComplete AND (d.shipment_tracking_number = :empty OR d.shipment_tracking_number IS NULL)) OR d.status = :statusCanceled)');
        $query->setParameter('statusCanceled', OrderStatus::STATUS_CANCELED);
        $query->setParameter('statusComplete', OrderStatus::STATUS_COMPLETE);
        $query->setParameter('empty', '');

        return $query;
    }

    private function getColumns() // Должны быть в таком же кол-ве и порядке как обьявленные колонки datatable
    {
        return [
            0 =>'d.inner_order_placed_date',
            1 =>'o.product_title',
            2 =>'d.shipment_tracking_number',
            3 =>'o.request_order_quantity',
            5 =>'o.order_item_shipping_cost',
            6 =>'o.order_item_price',
        ];
    }
}