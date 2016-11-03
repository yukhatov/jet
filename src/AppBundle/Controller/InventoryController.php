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
     * @Route("//inventory")
     */
    public function listAction(Request $request)
    {
        /*$sortColumn = 'id';

        if($request->get('sort'))
        {
            $sortColumn = $request->get('sort');
        }

        $inventoryRep = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem');

        $query = $inventoryRep->createQueryBuilder('i')
            ->orderBy('i.' . $sortColumn, 'ASC')
            ->getQuery();

        $inventory = $query->getResult();*/

        $inventory = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findAll();

        return $this->render('inventory/inventory.html.twig', array('inventory' => $inventory));
    }
}