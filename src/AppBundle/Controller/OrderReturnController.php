<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 13.12.16
 * Time: 12:15
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OrderReturnController extends Controller
{
    /**
     * @Route("/returns", name="returns")
     */
    public function listAction()
    {
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:OrderReturn')
            ->findBy([], ['innerReturnDate' => 'DESC']);


        return $this->render('return/returns.html.twig', array('ordersReturn' => $orders));
    }

    /**
     * @Route("/returns/{id}", name="return")
     */
    public function showAction($id, Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:OrderReturn')
            ->findOneBy(['id' => $id]);

        if(!$order){
            return new RedirectResponse($this->generateUrl('returns'));
        }

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findBy(['order_id' => $order->getOrderId()]);

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

        return $this->render('return/return.html.twig', array('return' => $order, 'items' => $items, 'inventoryItems' => $relatedInventoryItems));
    }
}