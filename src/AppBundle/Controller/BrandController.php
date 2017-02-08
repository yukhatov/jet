<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 30.01.17
 * Time: 17:27
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Rule;

class BrandController extends Controller
{
    /**
     * @Route("/removeRule/{brandId}", options={"expose"=true}, name="removeRule")
     */
    public function removeRuleAction($brandId)
    {
        $brand = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->findOneBy(['id' => $brandId]);

        if($brand){
            $rule = $this->getDoctrine()
                ->getRepository('AppBundle:Rule')
                ->findOneBy(['id' => $brand->getRuleId()]);

            $brand->setRuleId(NULL);
            $this->getDoctrine()->getEntityManager()->persist($brand);
            $this->getDoctrine()->getEntityManager()->remove($rule);
            $this->getDoctrine()->getEntityManager()->flush();

            $success = true;
        }else{
            $success = false;
        }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * @Route("/brand/saveRule/{brandId}", options={"expose"=true}, name="brandSaveRule")
     */
    public function saveRuleAction($brandId, Request $request)
    {
        $brand = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->findOneBy(['id' => $brandId]);

        if($brand){
            if($brand->getRuleId()){
                $rule = $this->getDoctrine()
                    ->getRepository('AppBundle:Rule')
                    ->findOneBy(['id' => $brand->getRuleId()]);


                $rule->setRequestData($request);
                $this->getDoctrine()->getEntityManager()->persist($rule);
                $this->getDoctrine()->getEntityManager()->flush();

                $success = true;
            }else{
                $rule = clone $brand->getProvider()->getRule();
                $rule->setRequestData($request);

                if(serialize($rule) != serialize($brand->getProvider()->getRule())){
                    $brand->setRule($rule);
                    $brand->setRuleId($rule->getId());

                    $this->getDoctrine()->getEntityManager()->persist($rule);
                    $this->getDoctrine()->getEntityManager()->persist($brand);
                    $this->getDoctrine()->getEntityManager()->flush();

                    $success = true;
                }else{
                    $success = false;
                }
            }
        }else{
            $success = false;
        }

        $ruleId = $success ? $rule->getId() : null;


        return new JsonResponse(array('success' => $success, 'ruleId' => $ruleId));
    }

    /**
     * @Route("/brand/getRule/{brandId}", options={"expose"=true}, name="brandGetRule")
     */
    public function getRuleAction($brandId, Request $request)
    {
        $brand = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->findOneBy(['id' => $brandId]);

        $rule = null;

        if($brand)
        {
            $rule = [
                'ruleId' => $brand->getRule()->getId(),
                'discount' => $brand->getRule()->getDiscount(),
                'shipping' => $brand->getRule()->getShipping(),
                'baseFactor' => $brand->getRule()->getBaseFactor(),
                'minFactor' => $brand->getRule()->getMinFactor(),
                'maxFactor' => $brand->getRule()->getMaxFactor(),
                'minIncome' => $brand->getRule()->getMinIncome(),
                'minIncomePerc' => $brand->getRule()->getMinIncomePerc(),
                'updatedAt' => $brand->getRule()->getUpdatedAt(),
            ];
        }

        return new JsonResponse(array('rule' => $rule));
    }
}