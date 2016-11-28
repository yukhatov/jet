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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_inventory")
 */

class InventoryItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bullet_1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bullet_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $main_image_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fulfillment_node_id;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $asin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $upc;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $brand_id;

    /**
     * @ManyToOne(targetEntity="Brand", inversedBy="inventoyItems")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $brand;

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
     * @ORM\Column(type="integer")
     */
    private $last_update;

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
        return number_format($this->price, 2);
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
        return number_format($this->whole_price, 2);
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

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @param mixed $fj_status
     */
    public function setFjStatus($fj_status)
    {
        $this->fj_status = $fj_status;
    }

    /**
     * @param mixed $fj_sub_status
     */
    public function setFjSubStatus($fj_sub_status)
    {
        $this->fj_sub_status = $fj_sub_status;
    }

    /**
     * @param mixed $brand_name
     */
    public function setBrandName($brand_name)
    {
        $this->brand_name = $brand_name;
    }

    /**
     * @param mixed $provider_name
     */
    public function setProviderName($provider_name)
    {
        $this->provider_name = $provider_name;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $upc
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $whole_price
     */
    public function setWholePrice($whole_price)
    {
        $this->whole_price = $whole_price;
    }

    /**
     * @param mixed $color_title
     */
    public function setColorTitle($color_title)
    {
        $this->color_title = $color_title;
    }

    /**
     * @param mixed $color_code
     */
    public function setColorCode($color_code)
    {
        $this->color_code = $color_code;
    }

    /**
     * @param mixed $size1
     */
    public function setSize1($size1)
    {
        $this->size1 = $size1;
    }

    /**
     * @param mixed $size2
     */
    public function setSize2($size2)
    {
        $this->size2 = $size2;
    }

    /**
     * @param mixed $size3
     */
    public function setSize3($size3)
    {
        $this->size3 = $size3;
    }

    /**
     * @param mixed $stock_count
     */
    public function setStockCount($stock_count)
    {
        $this->stock_count = $stock_count;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
}