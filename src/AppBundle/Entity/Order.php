<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 21.10.16
 * Time: 15:22
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_orders")
 */

class Order
{
    const DEFAULT_CARIER_PICK_UP_DATE = 259200; // tree days
    const DEFAULT_EXPECTED_DELIVERY_DATE = 864000; // ten days

    public function __construct()
    {
        $time = new \DateTime();

        $timestampNow = $time->getTimestamp();
        $timestampCarier= $timestampNow + self::DEFAULT_CARIER_PICK_UP_DATE;
        $timestampDelivery= $timestampNow + self::DEFAULT_EXPECTED_DELIVERY_DATE;

        $this->setResponseShipmentDate($time);

        $time = new \DateTime();
        $time->setTimestamp($timestampCarier);
        $this->setCarrierPickUpDate($time);

        $time = new \DateTime();
        $time->setTimestamp($timestampDelivery);
        $this->setExpectedDeliveryDate($time);
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */

    private $id;

    /**
     * @OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $base_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $request_shipping_method;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference_order_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipient_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipient_phone_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address_address1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address_city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address_state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address_zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $inner_order_placed_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $shipment_tracking_number;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer")
     */
    private $response_shipment_date;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer")
     */
    private $expected_delivery_date;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer")
     */
    private $carrier_pick_up_date;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $order_placed_date
     */
    public function setOrderPlacedDate($order_placed_date)
    {
        $this->order_placed_date = $order_placed_date;
    }

    /**
     * @return mixed
     */
    public function getRequestShippingMethod()
    {
        return $this->request_shipping_method;
    }

    /**
     * @param mixed $request_shipping_method
     */
    public function setRequestShippingMethod($request_shipping_method)
    {
        $this->request_shipping_method = $request_shipping_method;
    }

    /**
     * @return mixed
     */
    public function getRecipientName()
    {
        return $this->recipient_name;
    }

    /**
     * @param mixed $recipient_name
     */
    public function setRecipientName($recipient_name)
    {
        $this->recipient_name = $recipient_name;
    }

    /**
     * @return mixed
     */
    public function getRecipientPhoneNumber()
    {
        return $this->recipient_phone_number;
    }

    /**
     * @param mixed $recipient_phone_number
     */
    public function setRecipientPhoneNumber($recipient_phone_number)
    {
        $this->recipient_phone_number = $recipient_phone_number;
    }

    /**
     * @return mixed
     */
    public function getAddressLine()
    {
        return $this->address_address1;
    }

    /**
     * @param mixed $address_address1
     */
    public function setAddressLine($address_address1)
    {
        $this->address_address1 = $address_address1;
    }

    /**
     * @return mixed
     */
    public function getAddressCity()
    {
        return $this->address_city;
    }

    /**
     * @param mixed $address_city
     */
    public function setAddressCity($address_city)
    {
        $this->address_city = $address_city;
    }

    /**
     * @return mixed
     */
    public function getAddressState()
    {
        return $this->address_state;
    }

    /**
     * @param mixed $address_state
     */
    public function setAddressState($address_state)
    {
        $this->address_state = $address_state;
    }

    /**
     * @return mixed
     */
    public function getAddressZipCode()
    {
        return $this->address_zip_code;
    }

    /**
     * @param mixed $address_zip_code
     */
    public function setAddressZipCode($address_zip_code)
    {
        $this->address_zip_code = $address_zip_code;
    }

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
    public function getShipmentTrackingNumber()
    {
        return $this->shipment_tracking_number;
    }

    /**
     * @param mixed $shipment_tracking_number
     */
    public function setShipmentTrackingNumber($shipment_tracking_number)
    {
        $this->shipment_tracking_number = $shipment_tracking_number;
    }

    /**
     * @return mixed
     */
    public function getResponseShipmentDate()
    {
        return $this->response_shipment_date;
    }

    /**
     * @param mixed $response_shipment_date
     */
    public function setResponseShipmentDate($response_shipment_date)
    {
        $this->response_shipment_date = $response_shipment_date;
    }

    /**
     * @param mixed $expected_delivery_date
     */
    public function setExpectedDeliveryDate($expected_delivery_date)
    {
        $this->expected_delivery_date = $expected_delivery_date;
    }

    /**
     * @return mixed
     */
    public function getCarrierPickUpDate()
    {
        return $this->carrier_pick_up_date;
    }

    /**
     * @param mixed $carrier_pick_up_date
     */
    public function setCarrierPickUpDate($carrier_pick_up_date)
    {
        $this->carrier_pick_up_date = $carrier_pick_up_date;
    }

    public function ship(Order $orderModel)
    {
        if($this->getShipmentTrackingNumber())
        {
            return false;
        }

        if($orderModel->getShipmentTrackingNumber())
        {
            $this->setShipmentTrackingNumber($orderModel->getShipmentTrackingNumber());
        }

        if($orderModel->getCarrierPickUpDate())
        {
            $this->setCarrierPickUpDate($orderModel->getCarrierPickUpDate()->getTimestamp());
        }

        if($orderModel->getExpectedDeliveryDate())
        {
            $this->setExpectedDeliveryDate($orderModel->getExpectedDeliveryDate()->getTimestamp());
        }

        if($orderModel->getResponseShipmentDate())
        {
            $this->setResponseShipmentDate($orderModel->getResponseShipmentDate()->getTimestamp());
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getOrderPlacedDate()
    {
        return date("Y-m-d H:i", $this->inner_order_placed_date);
    }

    /**
     * @return mixed
     */
    public function getExpectedDeliveryDate($mode = 'TIMESTAMP')
    {
        if($mode != 'TIMESTAMP')
        {
            return date("Y-m-d H:i", intval($this->expected_delivery_date));
        }

        return $this->expected_delivery_date;
    }

    /**
     * @return mixed
     */
    public function getReferenceOrderId()
    {
        return $this->reference_order_id;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    public function getItemsCount()
    {
        return count( $this->items );
    }

    /**
     * @return mixed
     */
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * @param mixed $inner_order_placed_date
     */
    public function setInnerOrderPlacedDate($inner_order_placed_date)
    {
        $this->inner_order_placed_date = $inner_order_placed_date;
    }

    /**
     * @param mixed $base_price
     */
    public function setBasePrice($base_price)
    {
        $this->base_price = $base_price;
    }

    /**
     * @param mixed $reference_order_id
     */
    public function setReferenceOrderId($reference_order_id)
    {
        $this->reference_order_id = $reference_order_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}