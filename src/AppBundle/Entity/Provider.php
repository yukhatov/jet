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
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProviderRepository")
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
     * @ORM\Column(type="integer", nullable=false, name="rule_id")
     */
    private $ruleId;

    /**
     * @ManyToOne(targetEntity="Rule")
     */
    private $rule;

    /**
     * @OneToMany(targetEntity="Brand", mappedBy="provider")
     */
    private $brands;

    /**
     * @OneToMany(targetEntity="InventoryItem", mappedBy="provider")
     */
    private $inventoryItems;

    private $ruledInventoryItemsCount = 0;

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

    /**
     * @return mixed
     */
    public function getRuleId()
    {
        return $this->ruleId;
    }

    /**
     * @param mixed $ruleId
     */
    public function setRuleId($ruleId)
    {
        $this->ruleId = $ruleId;
    }

    /**
     * @return mixed
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param mixed $rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }
    /*public function getRuledInventoryItemsCount()
    {
        $count = 0;

        foreach ($this->inventoryItems as $item)
        {
            if($item->getRuleId())
            {
                $count++;
            }
        }

        return $count;
    }*/
    public function getRuledItemsCount()
    {
        return $this->ruledInventoryItemsCount;
    }

    public function setRuledItemsCount($count)
    {
        $this->ruledInventoryItemsCount = $count;
    }
}