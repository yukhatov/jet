<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 21.10.16
 * Time: 15:22
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_ordered_items")
 */

class OrderItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */

    private $id ;

    /**
     * @ManyToOne(targetEntity="Order", inversedBy="items")
     */
    private $order;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jet_defined_order_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $order_item_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $merchant_sku;

    /**
     * @ORM\Column(type="decimal")
     */
    private $order_item_price;

    /**
     * @ORM\Column(type="decimal")
     */
    private $order_item_shipping_cost;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt_order_item_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $request_order_quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $final_quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $request_order_cancel_qty;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $item_tax_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_url;

    /**
     * @ORM\Column(type="float")
     */
    private $price_adjustment;

    /**
     * @ORM\Column(type="float")
     */
    private $item_fees;

    /**
     * @ORM\Column(type="float")
     */
    private $regulatory_fees;

    /**
     * @ORM\Column(type="string")
     */
    private $product_title;

    private $hasRelatedInventoryItem = false;

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
        return number_format($this->order_item_price, 2);
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
        return number_format($this->order_item_shipping_cost, 2);
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

    /**
     * @return boolean
     */
    public function hasRelatedInventoryItem()
    {
        return $this->hasRelatedInventoryItem;
    }

    /**
     * @param boolean $hasRelatedInventoryItem
     */
    public function setHasRelatedInventoryItem($hasRelatedInventoryItem)
    {
        $this->hasRelatedInventoryItem = $hasRelatedInventoryItem;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * @param mixed $merchant_sku
     */
    public function setMerchantSku($merchant_sku)
    {
        $this->merchant_sku = $merchant_sku;
    }

    /**
     * @param mixed $order_item_price
     */
    public function setOrderItemPrice($order_item_price)
    {
        $this->order_item_price = $order_item_price;
    }

    /**
     * @param mixed $order_item_shipping_cost
     */
    public function setOrderItemShippingCost($order_item_shipping_cost)
    {
        $this->order_item_shipping_cost = $order_item_shipping_cost;
    }

    /**
     * @param mixed $request_order_quantity
     */
    public function setRequestOrderQuantity($request_order_quantity)
    {
        $this->request_order_quantity = $request_order_quantity;
    }

    /**
     * @param mixed $product_title
     */
    public function setProductTitle($product_title)
    {
        $this->product_title = $product_title;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

}