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

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
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

    private $ruledInventoryItemsCount = 0;

    /**
     * @ORM\Column(type="integer", nullable=true, name="rule_id")
     */
    private $ruleId;

    /**
     * @ManyToOne(targetEntity="Rule")
     */
    private $rule;

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
        if(!$this->rule){
            return $this->provider->getRule();
        }

        return $this->rule;
    }

    /**
     * @param mixed $rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }

    public function serialize(){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('provider', 'inventoryItems'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($this, 'json'));

        return $content;
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
