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
            'brands' => array()
        );

        if($get['providerId']){
            $output['brands'] = $this->getDoctrine()
                ->getRepository('AppBundle:InventoryItem')
                ->getBrands($get['providerId']);
        }

        return new JsonResponse($output);
    }

    /**
     * @Route("/item/saveRule/{itemId}", options={"expose"=true}, name="itemSaveRule")
     */
    public function saveRuleAction($itemId, Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findOneBy(['id' => $itemId]);

        $success = false;

        if($item){
            if($item->getRuleId() != 0)
            {
                $rule = $this->getDoctrine()
                    ->getRepository('AppBundle:Rule')
                    ->findOneBy(['id' => $item->getRuleId()]);


                $rule->setRequestData($request);
                $this->getDoctrine()->getEntityManager()->persist($rule);
                $this->getDoctrine()->getEntityManager()->flush();

                $success = true;
            }else{
                $rule = clone $item->getBrand()->getRule();
                $rule->setRequestData($request);

                if(serialize($rule) != serialize($item->getBrand()->getRule())){
                    $item->setRuleId($rule->getId());
                    $item->setRule($rule);

                    $this->getDoctrine()->getEntityManager()->persist($rule);
                    $this->getDoctrine()->getEntityManager()->persist($item);
                    $this->getDoctrine()->getEntityManager()->flush();

                    $success = true;
                }
            }
        }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * @Route("/itemRemoveRule/{itemId}", options={"expose"=true}, name="itemRemoveRule")
     */
    public function removeRuleAction($itemId)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findOneBy(['id' => $itemId]);

        if($item){
            $rule = $this->getDoctrine()
                ->getRepository('AppBundle:Rule')
                ->findOneBy(['id' => $item->getRuleId()]);

            $item->setRuleId(NULL);
            $this->getDoctrine()->getEntityManager()->persist($item);
            $this->getDoctrine()->getEntityManager()->remove($rule);
            $this->getDoctrine()->getEntityManager()->flush();

            $success = true;
        }else{
            $success = false;
        }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * @Route("/item/getRule/{itemId}", options={"expose"=true}, name="itemGetRule")
     */
    public function getRuleAction($itemId, Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:InventoryItem')
            ->findOneBy(['id' => $itemId]);

        $rule = null;

        if($item)
        {
            $rule = [
                'discount' => $item->getRule()->getDiscount(),
                'shipping' => $item->getRule()->getShipping(),
                'baseFactor' => $item->getRule()->getBaseFactor(),
                'minFactor' => $item->getRule()->getMinFactor(),
                'maxFactor' => $item->getRule()->getMaxFactor(),
                'minIncome' => $item->getRule()->getMinIncome(),
                'minIncomePerc' => $item->getRule()->getMinIncomePerc(),
                'updatedAt' => $item->getRule()->getUpdatedAt(),
            ];
        }

        return new JsonResponse(array('rule' => $rule));
    }
}