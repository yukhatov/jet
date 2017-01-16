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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
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
     * @GeneratedValue
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jet_defined_order_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $merchant_order_id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reference_order_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fulfillment_node;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alt_order_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hash_email;

    /**
     * @OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $exception_state;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2,  nullable=true, options={"default":0})
     */
    private $base_price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request_shipping_method;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request_service_level;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request_ship_by;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request_delivery_by;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recipient_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recipient_phone_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_address1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_address2;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_zip_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $order_placed_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $inner_order_placed_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $order_transmission_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $jet_request_directed_cancel;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default":0})
     */
    private $item_fees;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default":0})
     */
    private $item_tax;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default":0})
     */
    private $item_shipping_cost;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default":0})
     */
    private $item_shipping_tax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adjustment_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adjustment_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commission_id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, options={"default":0})
     */
    private $commission_value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request_shipping_carrier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $shipment_tracking_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updated_shipment_tracking_number;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $response_shipment_date;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $expected_delivery_date;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="integer", nullable=true)
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
        if(strlen($this->request_shipping_method) < 10){
            return $this->request_shipping_method;
        }else{
            preg_match('/([\S]+)/', $this->request_shipping_method, $match);

            return $match[1];
        }
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
    public function getAddressLine1()
    {
        return $this->address_address1;
    }

    /**
     * @param mixed $address_address1
     */
    public function setAddressLine1($address_address1)
    {
        $this->address_address1 = $address_address1;
    }

    /**
     * @return mixed
     */
    public function getAddressLine2()
    {
        return $this->address_address2;
    }

    /**
     * @param mixed $address_address2
     */
    public function setAddressLine2($address_address2)
    {
        $this->address_address2 = $address_address2;
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
            $todayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y'));

            $this->setResponseShipmentDate($orderModel->getResponseShipmentDate()->getTimestamp() + (time() - $todayMidnight));
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getOrderPlacedDate($format = "Y-m-d H:i")
    {
        return date($format, $this->inner_order_placed_date);
    }

    /**
     * @return mixed
     */
    public function getExpectedDeliveryDate($mode = 'TIMESTAMP')
    {
        if($mode != 'TIMESTAMP')
        {
            return date("Y-m-d", intval($this->expected_delivery_date));
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
        $count = 0;

        foreach ( $this->items as $item) {
            if( ($item->getFinalQuantity()) )
            {
                $count += $item->getFinalQuantity();
            }else{
                $count += $item->getQuantity();
            }
        }

        return $count;
    }

    /**
     * @return mixed
     */
    public function getBasePrice()
    {
        return number_format($this->base_price, 2);
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

    /**
     * @return mixed
     */
    public function getUpdatedShipmentTrackingNumber()
    {
        return $this->updated_shipment_tracking_number;
    }

    /**
     * @param mixed $updated_shipment_tracking_number
     */
    public function setUpdatedShipmentTrackingNumber($updated_shipment_tracking_number)
    {
        $this->updated_shipment_tracking_number = $updated_shipment_tracking_number;
    }
}