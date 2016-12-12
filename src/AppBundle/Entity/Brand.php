<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 17.11.16
 * Time: 16:21
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_brand")
 */

class Brand {

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
     * @ORM\Column(type="integer", nullable=true, name="provider_id")
     */
    private $providerId;

    /**
     * @ManyToOne(targetEntity="Provider", inversedBy="brands")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $provider;

    /**
     * @OneToMany(targetEntity="InventoryItem", mappedBy="brand")
     */
    private $inventoryItems;

    /**
     * @OneToMany(targetEntity="AppBundle\Entity\ReportInstock", mappedBy="brand")
     */
    /*private $reports;*/

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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return mixed
     */
   /* public function getReports()
    {
        return $this->reports;
    }*/
}
