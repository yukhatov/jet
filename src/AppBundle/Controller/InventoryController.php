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
     * @Route("/inventory", options={"expose"=true}, name="inventory")
     */
    public function listAction()
    {
        $providers = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findAll();

        $statuses = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->getStatuses();

        return $this->render('inventory/inventory.html.twig', array('providers' => $providers, 'statuses' => $statuses));
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
            'brands' => array()
        );

        if($get['providerId']){
            $output['brands'] = $this->getDoctrine()
                ->getRepository('AppBundle:InventoryItem')
                ->getBrands($get['providerId']);
        }

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

    private function serializeBrands($brands){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('provider', 'inventoryItems'));
        $serializer = new Serializer([$normalizer], $encoders);

        $content = json_decode($serializer->serialize($brands, 'json'));

        return $content;
    }
}