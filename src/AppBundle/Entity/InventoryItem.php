<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 03.11.16
 * Time: 11:55
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_inventory")
 */

class InventoryItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fj_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fj_sub_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $upc;

    /**
     * @ORM\Column(type="integer", length=50)
     */
    private $created;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $whole_price;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $color_title;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $color_code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $size1;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $size2;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $size3;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock_count;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->fj_status;
    }

    /**
     * @return mixed
     */
    public function getSubStatus()
    {
        return $this->fj_sub_status;
    }

    /**
     * @return mixed
     */
    public function getBrandName()
    {
        return $this->brand_name;
    }

    /**
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->provider_name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return date("Y-m-d H:i", $this->created);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getStockCount()
    {
        return $this->stock_count;
    }

    /**
     * @return mixed
     */
    public function getWholePrice()
    {
        return $this->whole_price;
    }

    /**
     * @return mixed
     */
    public function getColorTitle()
    {
        return $this->color_title;
    }

    /**
     * @return mixed
     */
    public function getColorCode()
    {
        return $this->color_code;
    }

    /**
     * @return mixed
     */
    public function getSize1()
    {
        return $this->size1;
    }

    /**
     * @return mixed
     */
    public function getSize2()
    {
        return $this->size2;
    }

    /**
     * @return mixed
     */
    public function getSize3()
    {
        return $this->size3;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }
}