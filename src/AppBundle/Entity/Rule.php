<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 27.01.17
 * Time: 11:59
 */
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_rule")
 */

class Rule {
    public function __construct()
    {
        $this->discount = 1;
        $this->shipping = 0;
        $this->baseFactor = 0;
        $this->minFactor = 0;
        $this->maxFactor = 0;
        $this->minIncome = 0;
        $this->minIncomePerc = 0;
    }

    public function setRequestData($request)
    {
        if($request->request->get('discount'))
        {
            $this->discount = $request->request->get('discount');
        }
        if($request->request->get('shipping'))
        {
            $this->shipping = $request->request->get('shipping');
        }
        if($request->request->get('baseFactor'))
        {
            $this->baseFactor = $request->request->get('baseFactor');
        }
        if($request->request->get('minFactor'))
        {
            $this->minFactor = $request->request->get('minFactor');
        }
        if($request->request->get('maxFactor'))
        {
            $this->maxFactor = $request->request->get('maxFactor');
        }
        if($request->request->get('minIncome'))
        {
            $this->minIncome = $request->request->get('minIncome');
        }
        if($request->request->get('minIncomePerc'))
        {
            $this->minIncomePerc = $request->request->get('minIncomePerc');
        }
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"default": 1})
     */
    private $discount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"default": 0})
     */
    private $shipping;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="base_factor", options={"default": 0})
     */
    private $baseFactor;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="min_factor", options={"default": 0})
     */
    private $minFactor;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="max_factor", options={"default": 0})
     */
    private $maxFactor;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="min_income_perc", options={"default": 0})
     */
    private $minIncomePerc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="min_income", options={"default": 0})
     */
    private $minIncome;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

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
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return mixed
     */
    public function getBaseFactor()
    {
        return $this->baseFactor;
    }

    /**
     * @param mixed $baseFactor
     */
    public function setBaseFactor($baseFactor)
    {
        $this->baseFactor = $baseFactor;
    }

    /**
     * @return mixed
     */
    public function getMinFactor()
    {
        return $this->minFactor;
    }

    /**
     * @param mixed $minFactor
     */
    public function setMinFactor($minFactor)
    {
        $this->minFactor = $minFactor;
    }

    /**
     * @return mixed
     */
    public function getMaxFactor()
    {
        return $this->maxFactor;
    }

    /**
     * @param mixed $maxFactor
     */
    public function setMaxFactor($maxFactor)
    {
        $this->maxFactor = $maxFactor;
    }

    /**
     * @return mixed
     */
    public function getMinIncomePerc()
    {
        return $this->minIncomePerc;
    }

    /**
     * @param mixed $minIncomePerc
     */
    public function setMinIncomePerc($minIncomePerc)
    {
        $this->minIncomePerc = $minIncomePerc;
    }

    /**
     * @return mixed
     */
    public function getMinIncome()
    {
        return $this->minIncome;
    }

    /**
     * @param mixed $minIncome
     */
    public function setMinIncome($minIncome)
    {
        $this->minIncome = $minIncome;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}