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

        return $this->render('inventory/inventory.html.twig', array('inventory' => $inventory, 'providers' => $providers, 'brands' => $brands, 'params' => $params));
    }

    private function getParameters($providerId, $brandId){
        return ['selectedProvider' => $providerId,
                'selectedBrand' => $brandId
        ];
    }
}