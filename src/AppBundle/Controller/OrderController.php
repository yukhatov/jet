<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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

    /**
     * @Route("/orders", name="orders")
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findAll();

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

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findBy(['order_id' => $id]);

        $statuses = $this->getDoctrine()
            ->getRepository('AppBundle:Status')
            ->findAll();

        $orderModel = new Order();
        $form = $this->createFormBuilder($orderModel)
            ->add('shipment_tracking_number', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Tracking number'))
            ->add('response_shipment_date', 'Symfony\Component\Form\Extension\Core\Type\DateTimeType', array('label' => 'Response shipment date'))
            ->add('carrier_pick_up_date', 'Symfony\Component\Form\Extension\Core\Type\DateTimeType' , array('label' => 'Carrier pick up date'))
            ->add('expected_delivery_date', 'Symfony\Component\Form\Extension\Core\Type\DateTimeType', array('label' => 'Expected delivery date'))
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Ship'))
            ->getForm();
        /*$form = $this->createFormBuilder($orderModel)
            ->add('shipment_tracking_number', TextType::class, array('label' => 'Tracking number'))
            ->add('response_shipment_date', DateTimeType::class, array('label' => 'Response shipment date'))
            ->add('carrier_pick_up_date', DateTimeType::class, array('label' => 'Carrier pick up date'))
            ->add('expected_delivery_date', DateTimeType::class, array('label' => 'Expected delivery date'))
            ->add('save', SubmitType::class, array('label' => 'Ship'))
            ->getForm();*/

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $orderModel = $form->getData();

            $order->ship($orderModel);

            $em->persist($order);
            $em->flush();

            $this->actionCreate(strval($order->getId()), self::ACTION_TYPE_SHIP);
        }

        return $this->render('order/order.html.twig', array('order' => $order, 'items' => $items, 'statuses' => $statuses, 'form' => $form->createView()));
    }

    /**
     * @Route("//orders/{orderId}/items/{itemId}/edit/{quantity}")
     */
    public function editAction(Request $request)//вынести в контроллер
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
     * @Route("//orders/{orderId}/approve")
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
     * @Route("//orders/{orderId}/cancel")
     */
    public function cancelAction(Request $request)
    {
        if($request->get('orderId') != null)
        {
            if($this->actionCreate($request->get('orderId'), self::ACTION_TYPE_CANCEL))
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
            ->getRepository('AppBundle:Status')
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
