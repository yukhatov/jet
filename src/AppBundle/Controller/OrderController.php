<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * @Route("//orders")
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findAll();

        return $this->render('order/orders.html.twig', array('orders' => $orders));
    }

    /**
     * @Route("//orders/{id}")
     */
    public function showAction($id)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Order')
            ->findOneBy(['id' => $id]);

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findBy(['order_id' => $id]);

        return $this->render('order/order.html.twig', array('order' => $order, 'items' => $items));
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
}
