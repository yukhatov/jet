<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 03.11.16
 * Time: 11:47
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class InventoryController extends Controller
{
    /**
     * @Route("/inventory", name="inventory")
     */
    public function listAction()
    {
        $inventory = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findAll();

        return $this->render('inventory/inventory.html.twig', array('inventory' => $inventory));
    }
}