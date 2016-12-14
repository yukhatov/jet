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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

       /* if($brandId){
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
        }*/

        return $this->render('inventory/inventory.html.twig', array(/*'inventory' => $inventory,*/ 'providers' => $providers, 'brands' => $brands, 'params' => $params));
    }

    /**
     * @Route("/inventoryTableData", options={"expose"=true}, name="inventoryTableData")
     */
    public function inventoryDataAction(Request $request)
    {
        $get = $request->query->all();

        $inventory = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findByParams($get);

        $inventoryTotalByParamsCount = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->getTotalCountByParams($get);

        $inventoryTotalCount = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->getTotalInventoryCount();

        $inventory = $this->serializeInvetory($inventory);

        $output = array(
            "draw" =>  intval($get['draw']),
            "recordsTotal" => $inventoryTotalCount,
            "recordsFiltered" => $inventoryTotalByParamsCount,
            "data" => $inventory,
            "requestParameters" => $get,
        );

        return new JsonResponse($output);
    }

    private function serializeInvetory($inventory){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('brand', 'provider'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($inventory, 'json'));

        return $content;
    }

    private function getParameters($providerId, $brandId){
        return ['selectedProvider' => $providerId,
                'selectedBrand' => $brandId
        ];
    }
}