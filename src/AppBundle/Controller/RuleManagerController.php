<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 30.01.17
 * Time: 12:14
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Rule;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RuleManagerController extends Controller
{
    /**
     * @Route("/ruleManager", name="ruleManager")
     */
    public function indexAction()
    {
        $providers = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findAll();

        /**
         * counting ruled items
         */
        foreach ($providers as $provider) {
            $provider->setRuledItemsCount( $this->getDoctrine()->getRepository('AppBundle:Provider')->getRuledItemsCount($provider->getId()) );

            foreach ($provider->getBrands() as $brand) {
                $brand->setRuledItemsCount( $this->getDoctrine()->getRepository('AppBundle:Brand')->getRuledItemsCount($brand->getId()) );
            }
        }

        return $this->render('ruleManager/ruleManager.html.twig', ['providers' => $providers]);
    }

    /**
     * @Route("/ruleManagerBrand/{brandId}", name="ruleManagerBrand")
     */
    public function brandAction($brandId)
    {
        return $this->render('ruleManager/ruleManagerBrand.html.twig', ['brandId' => $brandId]);
    }

    /**
     * @Route("/ruleManagerBrandTableData", options={"expose"=true}, name="ruleManagerBrandTableData")
     */
    public function ruleManagerBrandDataAction(Request $request)
    {
        $get = $request->query->all();

        $inventory = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findByParamsSerialized($get);

        $inventoryTotalByParamsCount = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->getTotalCountByParams($get);

        $inventoryTotalCount = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->getTotalInventoryCount();

        $output = array(
            "draw" =>  intval($get['draw']),
            "recordsTotal" => $inventoryTotalCount,
            "recordsFiltered" => $inventoryTotalByParamsCount,
            "data" => $inventory,
            "requestParameters" => $get,
        );

        return new JsonResponse($output);
    }
}