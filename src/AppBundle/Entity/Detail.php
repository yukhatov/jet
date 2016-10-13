<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.10.16
 * Time: 14:26
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="amz_glasses_item_detail")
 */

class Detail
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */

    private $detail_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $detail_upc;

    /**
     * @return mixed
     */
    public function getDetailUpc()
    {
        return $this->detail_upc;
    }

    /**
     * @param mixed $detail_upc
     */
    public function setDetailUpc($detail_upc)
    {
        $this->detail_upc = $detail_upc;
    }



}