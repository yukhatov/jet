<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.12.16
 * Time: 14:27
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
            $column = $this->getColumns()[self::TITLE_COLUMN];

            if(preg_match('/([0-9]{12,13})/', $value))
            {
                $column = $this->getColumns()[self::UPC_COLUMN];
            }elseif (preg_match('/(D[0-9]+)/', $value)){
                $column = $this->getColumns()[self::SKU_COLUMN];
            }elseif (preg_match('/([0-9A-Z]{10})/', $value)){
                $column = $this->getColumns()[self::ASIN_COLUMN];
            }

            $query->where($query->expr()->like($column, ':value'))
                ->setParameters(['value' => '%' . $value . '%']);
        }

        if($params['brandId']){
            $query->where('i.brand_id = :brandId')
                ->setParameters(['brandId' => $params['brandId']]);
        }else{
            if($params['providerId']){
                $query->where('i.provider_id = :providerId')
                    ->setParameters(['providerId' => $params['providerId']]);
            }
        }

        return $query;
    }

    private function getColumns()
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
            'i.created'
        ];
    }
}