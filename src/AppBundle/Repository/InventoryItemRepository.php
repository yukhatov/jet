<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.12.16
 * Time: 14:27
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class InventoryItemRepository extends EntityRepository
{
    const TITLE_COLUMN = 2;
    const UPC_COLUMN = 6;
    const SKU_COLUMN = 7;
    const ASIN_COLUMN = 8;

    public function findByParams($params)
    {
        $query = $this->getQueryByParams($params);

        if(isset($params['start']) and isset($params['length'])){
            $query->setFirstResult( $params['start'] )
                ->setMaxResults( $params['length'] );
        }

        return $query->getQuery()
            ->getResult();
    }

    public function getTotalCountByParams($params)
    {
        $query = $this->getQueryByParams($params)
            ->select('count(i.id)');

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalInventoryCount()
    {
        $query = $this->createQueryBuilder('i')
            ->select('count(i.id)');

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    public function getStatuses()
    {
        $query = $this->createQueryBuilder('i')
            ->select('distinct(i.fj_status)');

        return $query->getQuery()
            ->getResult();
    }

    public function getBrands($providerId)
    {
        $query = $this->createQueryBuilder('i')
            ->select(['b.id', 'b.title'])
            ->join('i.brand', 'b')
            ->where('i.provider_id = ' . $providerId)
            ->groupBy('i.brand_id');

        return $query->getQuery()
            ->getResult();
    }

    private function getQueryByParams($params)
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.brand', 'b')
            ->join('i.provider', 'p');

        if(!empty($params['order'][0]))
        {
            $column = $this->getColumns()[$params['order'][0]['column']];
            $order = $params['order'][0]['dir'];

            $query->orderBy($column, $order);
        }

        if(!empty($params['search']['value'])){
            $value = $params['search']['value'];

            $query
                ->andWhere($query->expr()->like($this->getColumns()[self::TITLE_COLUMN], ':value'))
                ->orWhere($query->expr()->like($this->getColumns()[self::UPC_COLUMN], ':value'))
                ->orWhere($query->expr()->like($this->getColumns()[self::SKU_COLUMN], ':value'))
                ->orWhere($query->expr()->like($this->getColumns()[self::ASIN_COLUMN], ':value'))
                ->setParameter('value', '%' . $value . '%');
        }

        if($params['brandId']){
            $query->andWhere('i.brand_id = :brandId')
                ->setParameter('brandId', $params['brandId']);
        }else{
            if($params['providerId']){
                $query->andWhere('i.provider_id = :providerId')
                    ->setParameter('providerId', $params['providerId']);
            }
        }

        if(!empty($params['stock'])){
            if($params['stock'] == 1){
                $query->andWhere('i.stock_count >= 1');
            }else{
                $query->andWhere('i.stock_count < 1');
            }
        }

        if(!empty($params['status'])){
            $query->andWhere($query->expr()->like('i.fj_status', ':status'))
                ->setParameter('status', $params['status']);
        }

        return $query;
    }

    private function getColumns() // Должны быть в таком же кол-ве и порядке как обьявленные колонки datatable в inventory.js
    {
        return [
            'p.title',
            'b.title',
            'i.title',
            'i.color_title',
            'i.color_code',
            'i.size1',
            'i.upc',
            'i.sku',
            'i.asin',
            'i.price',
            'i.whole_price',
            'i.stock_count',
            'i.fj_status',
            'i.created',
            'i.ruleId'
        ];
    }

    public function findByParamsSerialized($params){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('brand', 'provider'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($this->findByParams($params), 'json'));

        return $content;
    }

    public function findSerializedOneBy($array)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('brand', 'provider'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($this->findOneBy($array), 'json'));

        return $content;
    }
}