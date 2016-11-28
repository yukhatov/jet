<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 23.11.16
 * Time: 14:47
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_report_instock")
 */

class ReportInstock
{
    public function __construct(Brand $brand = null, $instockCount = 0, $outstockCount = 0)
    {
        if($brand)
        {
            $date = new \DateTime();
            $date->setTimestamp(time());
            $date->format('Y-m-d');

            $this->setBrand($brand);
            $this->setBrandId($brand->getId());
            $this->setProvider($brand->getProvider());
            $this->setProviderId($brand->getProviderId());
            $this->setInstockCount($instockCount);
            $this->setOutstockCount($outstockCount);
            $this->setTime($date);
        }
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $time;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $brand_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $provider_id;

    /**
     * @ManyToOne(targetEntity="Provider")
     */
    private $provider;

    /**
     * @ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $brand;

    /**
     * @ORM\Column(type="integer")
     */
    private $instock_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $outstock_count;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * @param mixed $brand_id
     */
    public function setBrandId($brand_id)
    {
        $this->brand_id = $brand_id;
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

    /**
     * @return mixed
     */
    public function getInstockCount()
    {
        return $this->instock_count;
    }

    /**
     * @param mixed $instock_count
     */
    public function setInstockCount($instock_count)
    {
        $this->instock_count = $instock_count;
    }

    /**
     * @return mixed
     */
    public function getOutstockCount()
    {
        return $this->outstock_count;
    }

    /**
     * @param mixed $outstock_count
     */
    public function setOutstockCount($outstock_count)
    {
        $this->outstock_count = $outstock_count;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @param mixed $provider_id
     */
    public function setProviderId($provider_id)
    {
        $this->provider_id = $provider_id;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}