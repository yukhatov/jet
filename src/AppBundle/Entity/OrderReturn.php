<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 13.12.16
 * Time: 12:21
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_order_returns")
 */

class OrderReturn {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @GeneratedValue
     */

    private $id;

    /**
     * @ORM\Column(type="integer", name="order_id")
     */
    private $orderId;

    /**
     * @OneToOne(targetEntity="Order")
     */
    private $order;

    /**
     * @ORM\Column(type="string", length=255, name="merchant_order_id", nullable=true)
     */
    private $merchantOrderId;

    /**
     * @ORM\Column(type="string", length=255, name="jet_defined_order_id", nullable=true)
     */
    private $jetDefinedOrderId;

    /**
     * @ORM\Column(type="string", length=255, name="merchant_return_authorization_id", nullable=true)
     */
    private $merchantReturnAuthorizationId;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="merchant_return_charge", options={"default":0})
     */
    private $merchantReturnCharge;

    /**
     * @ORM\Column(type="string", length=255, name="reference_order_id", nullable=true)
     */
    private $referenceOrderId;

    /**
     * @ORM\Column(type="string", length=255, name="reference_return_authorization_id", nullable=true)
     */
    private $referenceReturnAuthorizationId;

    /**
     * @ORM\Column(type="string", length=255, name="return_date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\Column(type="integer", name="inner_return_date", nullable=true)
     */
    private $innerReturnDate;

    /**
     * @ORM\Column(type="string", length=255, name="return_status", nullable=true)
     */
    private $returnStatus;

    /**
     * @ORM\Column(type="string", length=255, name="return_shipping_carrier", nullable=true)
     */
    private $returnShippingCarrier;

    /**
     * @ORM\Column(type="string", length=50, name="return_tracking_number", nullable=true)
     */
    private $returnTrackingNumber;

    /**
     * @return mixed
     */
    public function getReturnTrackingNumber()
    {
        return $this->returnTrackingNumber;
    }

    /**
     * @param mixed $returnTrackingNumber
     */
    public function setReturnTrackingNumber($returnTrackingNumber)
    {
        $this->returnTrackingNumber = $returnTrackingNumber;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getMerchantOrderId()
    {
        return $this->merchantOrderId;
    }

    /**
     * @param mixed $merchantOrderId
     */
    public function setMerchantOrderId($merchantOrderId)
    {
        $this->merchantOrderId = $merchantOrderId;
    }

    /**
     * @return mixed
     */
    public function getJetDefinedOrderId()
    {
        return $this->jetDefinedOrderId;
    }

    /**
     * @param mixed $jetDefinedOrderId
     */
    public function setJetDefinedOrderId($jetDefinedOrderId)
    {
        $this->jetDefinedOrderId = $jetDefinedOrderId;
    }

    /**
     * @return mixed
     */
    public function getMerchantReturnAuthorizationId()
    {
        return $this->merchantReturnAuthorizationId;
    }

    /**
     * @param mixed $merchantReturnAuthorizationId
     */
    public function setMerchantReturnAuthorizationId($merchantReturnAuthorizationId)
    {
        $this->merchantReturnAuthorizationId = $merchantReturnAuthorizationId;
    }

    /**
     * @return mixed
     */
    public function getMerchantReturnCharge()
    {
        return $this->merchantReturnCharge;
    }

    /**
     * @param mixed $merchantReturnCharge
     */
    public function setMerchantReturnCharge($merchantReturnCharge)
    {
        $this->merchantReturnCharge = $merchantReturnCharge;
    }

    /**
     * @return mixed
     */
    public function getReferenceOrderId()
    {
        return $this->referenceOrderId;
    }

    /**
     * @param mixed $referenceOrderId
     */
    public function setReferenceOrderId($referenceOrderId)
    {
        $this->referenceOrderId = $referenceOrderId;
    }

    /**
     * @return mixed
     */
    public function getReferenceReturnAuthorizationId()
    {
        return $this->referenceReturnAuthorizationId;
    }

    /**
     * @param mixed $referenceReturnAuthorizationId
     */
    public function setReferenceReturnAuthorizationId($referenceReturnAuthorizationId)
    {
        $this->referenceReturnAuthorizationId = $referenceReturnAuthorizationId;
    }

    /**
     * @return mixed
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * @param mixed $returnDate
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
    }

    /**
     * @return mixed
     */
    public function getReturnStatus()
    {
        return $this->returnStatus;
    }

    /**
     * @param mixed $returnStatus
     */
    public function setReturnStatus($returnStatus)
    {
        $this->returnStatus = $returnStatus;
    }

    /**
     * @return mixed
     */
    public function getReturnShippingCarrier()
    {
        return $this->returnShippingCarrier;
    }

    /**
     * @param mixed $returnShippingCarrier
     */
    public function setReturnShippingCarrier($returnShippingCarrier)
    {
        $this->returnShippingCarrier = $returnShippingCarrier;
    }

    /**
     * @return mixed
     */
    public function getInnerReturnDate()
    {
        return date("Y-m-d H:i", $this->innerReturnDate);
    }

    /**
     * @param mixed $innerReturnDate
     */
    public function setInnerReturnDate($innerReturnDate)
    {
        $this->innerReturnDate = $innerReturnDate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}