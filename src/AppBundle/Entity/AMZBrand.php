<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 11.10.16
 * Time: 14:42
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="amz_glasses_brand")
 */

class AMZBrand {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $brand_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand_title;

    /**
     * @ORM\Column(type="integer")
     */
    private $provider_id;

    /**
     * @return mixed
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * @return mixed
     */
    public function getBrandTitle()
    {
        return $this->brand_title;
    }

}
