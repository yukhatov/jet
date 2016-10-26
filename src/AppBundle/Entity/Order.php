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
 * @ORM\Table(name="jet_orders")
 */

class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $request_shipping_method;

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
     * @return mixed
     */
    public function getOrderPlacedDate()
    {
        return $this->order_placed_date;
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
}