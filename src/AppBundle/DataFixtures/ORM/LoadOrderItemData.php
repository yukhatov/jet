<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.11.16
 * Time: 12:15
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderReturn;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrderItemData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $id = 1;

        $order1 = $this->newOrder($id, $manager, 'complete');
        $order2 = $this->newOrder($id + 1, $manager);
        $order3 = $this->newOrder($id + 2, $manager);

        $this->newItem($order1, $manager);
        $this->newItem($order1, $manager);
        $this->newItem($order2, $manager);
        $this->newItem($order3, $manager);

        $this->newOrderReturn($order1, $manager);
    }

    private function newItem(Order $order, ObjectManager $manager)
    {
        $item = new OrderItem();
        $item->setOrder($order);
        $item->setOrderId($order->getId());
        $item->setHasRelatedInventoryItem(false);
        $item->setRequestOrderQuantity(2);
        $item->setMerchantSku('D378333');
        $item->setOrderItemPrice(99.2);
        $item->setOrderItemShippingCost(6.9);
        $item->setProductTitle('Ray Ban RB 3300');
        $item->setReturnQuantity(0);

        $manager->persist($item);
        $manager->flush();
    }

    private function newOrder($id, ObjectManager $manager, $status = 'created')
    {
        $order = new Order();
        $order->setAddressLine1('21342 sw Roellich Ave');
        $order->setAddressLine2('2B');
        $order->setId($id);
        $order->setStatus($status);
        $order->setAddressCity('Toronto');
        $order->setAddressState('TR');
        $order->setAddressZipCode('54000');
        $order->setInnerOrderPlacedDate(1478642400);
        $order->setOrderPlacedDate('2015-12-17T18:04:28.6432544Z');
        $order->setRecipientName('John Doe');
        $order->setRecipientPhoneNumber('+380984337258');
        $order->setRequestShippingMethod('UPS');
        $order->setBasePrice(99.99);
        $order->setReferenceOrderId('1');
        $order->setShipmentTrackingNumber(NULL);
        $order->setCarrierPickUpDate(NULL);
        $order->setExpectedDeliveryDate(NULL);
        $order->setResponseShipmentDate(NULL);

        $manager->persist($order);
        $manager->flush();

        return $order;
    }

    private function newOrderReturn(Order $order, ObjectManager $manager)
    {
        $orderReturn = new OrderReturn();
        $orderReturn->setOrder($order);
        $orderReturn->setOrderId($order->getId());
        $orderReturn->setReturnTrackingNumber('test');
        $orderReturn->setMerchantReturnCharge(0);
        $orderReturn->setInnerReturnDate(1478642400);

        $manager->persist($orderReturn);
        $manager->flush();
    }
}