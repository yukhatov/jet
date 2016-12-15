<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InventoryItem;
use AppBundle\Entity\OrderStatus;
use AppBundle\Entity\Order;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Action;

class OrderController extends Controller
{
    const ACTION_TYPE_AKNOWLEDGE = 'try_acknowledge';
    const ACTION_TYPE_SHIP = 'try_ship_order';
    const ACTION_TYPE_CANCEL = 'try_cancel_order';
    const ACTION_TYPE_UPDATE = 'try_update_order';
    const ACTION_TYPE_RETURN = 'try_return_order';

    /**
     * @Route("/orders", name="orders")
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findBy([], ['inner_order_placed_date' => 'DESC']);

        return $this->render('order/orders.html.twig', array('orders' => $orders));
    }

    /**
     * @Route("/orders/{id}", name="order")
     */
    public function showAction($id, Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findOneBy(['id' => $id]);

        if(!$order){
            return new RedirectResponse($this->generateUrl('orders'));
        }

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findBy(['order_id' => $id]);

        $statuses = $this->getDoctrine()
            ->getRepository('AppBundle:ApproveStatus')
            ->findAll();

        $relatedInventoryItems = array();

        foreach ($items as $item) {
            $inventoryItem = $this->getDoctrine()
                ->getRepository('AppBundle:InventoryItem')
                ->findOneBy(['sku' => $item->getMerchantSku()]);

            if($inventoryItem)
            {
                $item->setHasRelatedInventoryItem(true);
                $relatedInventoryItems[$item->getMerchantSku()] = $inventoryItem;
            }
        }

        $orderModel = new Order();
        $form = $this->createFormBuilder($orderModel)
            ->add('shipment_tracking_number', /*TextType::class*/'Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Tracking number'))
            ->add('response_shipment_date', 'Symfony\Component\Form\Extension\Core\Type\DateType', array('label' => 'Response shipment date', 'format' => 'ddMMMyyyy'))
            ->add('carrier_pick_up_date', 'Symfony\Component\Form\Extension\Core\Type\DateType' , array('label' => 'Carrier pick up date', 'format' => 'ddMMMyyyy'))
            ->add('expected_delivery_date', 'Symfony\Component\Form\Extension\Core\Type\DateType', array('label' => 'Expected delivery date', 'format' => 'ddMMMyyyy'))
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Ship'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $orderModel = $form->getData();

            $order->ship($orderModel);

            $em->persist($order);
            $em->flush();

            $this->actionCreate(strval($order->getId()), self::ACTION_TYPE_SHIP);
        }

        return $this->render('order/order.html.twig', array('order' => $order, 'items' => $items, 'inventoryItems' => $relatedInventoryItems, 'statuses' => $statuses, 'form' => $form->createView()));
    }

    /**
     * @Route("/edit", options={"expose"=true}, name="edit")
     */
    public function editAction(Request $request)
    {
        $success = false;

        if($request->get('orderId') != null and $request->get('tn') != null) {
            $order = $this->getDoctrine()
                ->getRepository('AppBundle:Order')
                ->findOneBy(['id' => $request->get('orderId')]);

            if($order and $order->getStatus() == OrderStatus::STATUS_COMPLETE)
            {
                $order->setUpdatedShipmentTrackingNumber($request->get('tn'));

                $this->getDoctrine()->getEntityManager()->persist($order);
                $this->getDoctrine()->getEntityManager()->flush();

                $success = $this->actionCreate($request->get('orderId'), self::ACTION_TYPE_UPDATE);
            }
        }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * @Route("/editItem", options={"expose"=true}, name="editItem")
     */
    public function editItemAction(Request $request)//вынести в контроллер
    {
        if($request->get('quantity') != null and $request->get('orderId') != null and $request->get('itemId') != null)
        {
            $quantity = $request->get('quantity');

            $em = $this->getDoctrine()->getEntityManager();
            $item = $em->getRepository('AppBundle:OrderItem')
                ->findOneBy(['order_id' => $request->get('orderId'), 'id' => $request->get('itemId')]);

            $item->setFinalQuantity($request->get('quantity'));

            $em->flush();
        }

        $response = new Response(json_encode(array('quantity' => isset($quantity) ? $quantity : null)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/approve", options={"expose"=true}, name="approve")
     */
    public function approveAction(Request $request)
    {
        if($request->get('statusId') != null and $request->get('orderId') != null)
        {
            if($this->actionCreate($request->get('orderId'), self::ACTION_TYPE_AKNOWLEDGE, $request->get('statusId')))
            {
                return new JsonResponse(array('success' => true));
            }
        }

        return new JsonResponse(array('success' => false));
    }

    /**
     * @Route("/createAction", options={"expose"=true}, name="createAction")
     */
    public function createActionAction(Request $request)
    {
        if($request->get('orderId') != null and $request->get('action') != null)
        {
            if($this->actionCreate($request->get('orderId'), $request->get('action')))
            {
                return new JsonResponse(array('success' => true));
            }
        }

        return new JsonResponse(array('success' => false));
    }

    protected function actionCreate($orderId, $actionType, $statusId = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $status = $this->getDoctrine()
            ->getRepository('AppBundle:ApproveStatus')
            ->findOneBy(['id' => $statusId]);

        $action = new Action($orderId, $actionType, $status);

        if($action)
        {
            $em->persist($action);
            $em->flush();

            return true;
        }else{
            return false;
        }
    }
}
