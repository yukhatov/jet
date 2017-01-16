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

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class OrderItemRepository extends EntityRepository
{
    public function findSummaryByDateRange($from, $to){
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

        if(isset($params['fromDate']) and isset($params['toDate'])){
            $query->andWhere('d.inner_order_placed_date >= :from');
            $query->andWhere('d.inner_order_placed_date <= :to');
            $query->setParameter('from', strtotime($params['fromDate']));
            $query->setParameter('to', strtotime($params['toDate']));
        }

        if(!empty($params['order'][0]))
        {
            $column = $this->getColumns()[$params['order'][0]['column']];
            $order = $params['order'][0]['dir'];

            $query->orderBy($column, $order);
        }

        return $query;
    }

    private function getColumns() // Должны быть в таком же кол-ве и порядке как обьявленные колонки datatable
    {
        return [
            0 =>'o.product_title',
            1 =>'d.inner_order_placed_date',
            2 =>'d.status',
            3 =>'d.shipment_tracking_number',
            4 =>'o.qauntity',
            6 =>'o.order_item_shipping_cost',
            7 =>'o.order_item_price',
        ];
    }
}