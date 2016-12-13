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
use Symfony\Component\HttpFoundation\JsonResponse;

class InventoryController extends Controller
{
    /**
     * @Route("/inventory/{providerId}/{brandId}", options={"expose"=true}, name="inventory")
     */
    public function listAction($providerId = 0, $brandId = 0)
    {
        $params = $this->getParameters($providerId, $brandId);

        $providers = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findAll();

        $brands = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->findBy(['providerId' => $providerId]);

        if($brandId){
            $inventory = $this->getDoctrine()
                ->getRepository('AppBundle:InventoryItem')
                ->findBy(['brand_id' => $brandId]);
        }else{
            if($providerId)
            {
                $inventory = $this->getDoctrine()
                    ->getRepository('AppBundle:InventoryItem')
                    ->findBy(['provider_id' => $providerId]);
            }else{
                $inventory = $this->getDoctrine()
                    ->getRepository('AppBundle:InventoryItem')
                    ->findAll();
            }
        }

        return $this->render('inventory/inventory.html.twig', array('inventory' => /*$inventory*/0, 'providers' => $providers, 'brands' => $brands, 'params' => $params));
    }

    /**
     * @Route("/inventoryTable", options={"expose"=true}, name="inventoryTable")
     */
    public function inventoryAction()
    {
        $table = 'jet_inventory';

        $primaryKey = 'id';

        $columns = array(
            array( 'db' => 'upc', 'dt' => 0 ),
        );

        $sql_details = array(
            'user' => 'root',
            'pass' => '228834228834n',
            'db'   => 'jet',
            'host' => 'localhost'
        );

        return new JsonResponse([$_GET, $sql_details, $table, $primaryKey, $columns]);

    }

    private function getParameters($providerId, $brandId){
        return ['selectedProvider' => $providerId,
                'selectedBrand' => $brandId
        ];
    }
}