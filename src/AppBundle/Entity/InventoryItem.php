<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 03.11.16
 * Time: 11:55
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}