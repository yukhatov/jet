<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 21.10.16
 * Time: 15:22
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_ordered_items")
 */

class OrderItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */

    private $id ;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_id;

    /**
     * @ORM\Column(type="decimal")
     */
    private $order_item_price;

    /**
     * @ORM\Column(type="decimal")
     */
    private $order_item_shipping_cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $request_order_quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $final_quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $merchant_sku;

    /**
     * @ORM\Column(type="string")
     */
    private $product_title;

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
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->order_item_price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->request_order_quantity;
    }

    /**
     * @return mixed
     */
    public function getFinalQuantity()
    {
        return $this->final_quantity;
    }

    /**
     * @param mixed $final_quantity
     */
    public function setFinalQuantity($final_quantity)
    {
        $this->final_quantity = $final_quantity;
    }

    /**
     * @return mixed
     */
    public function getShippingCost()
    {
        return $this->order_item_shipping_cost;
    }

    /**
     * @return mixed
     */
    public function getMerchantSku()
    {
        return $this->merchant_sku;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->product_title;
    }

    public function getSelectValues()
    {
        $values = array();
        $tempQnt = 0;

        while ($tempQnt <= $this->getQuantity())
        {
            $values[] = $tempQnt;
            $tempQnt = $tempQnt + 1;
        }

        return $values;
    }

    public function getSelectedValue()
    {
        if(isset($this->final_quantity))
        {
            return $this->getFinalQuantity();
        }else{
            return $this->getQuantity();
        }
    }
}