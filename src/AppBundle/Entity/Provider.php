<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 17.11.16
 * Time: 16:21
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_provider")
 */

class Provider {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @OneToMany(targetEntity="Brand", mappedBy="provider")
     */
    private $brands;

    /**
     * @OneToMany(targetEntity="InventoryItem", mappedBy="provider")
     */
    private $inventoryItems;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}