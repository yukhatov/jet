<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 02.02.17
 * Time: 15:22
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Rule;

class ProviderController extends Controller
{
    /**
     * @Route("/provider/saveRule/{providerId}", options={"expose"=true}, name="providerSaveRule")
     */
    public function saveRuleAction($providerId, Request $request)
    {
        $provider = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findOneBy(['id' => $providerId]);

        $success = false;

        if ($provider) {
            if($provider->getRuleId() != 0)
            {
                $rule = $this->getDoctrine()
                    ->getRepository('AppBundle:Rule')
                    ->findOneBy(['id' => $provider->getRuleId()]);


                $rule->setRequestData($request);
                $this->getDoctrine()->getEntityManager()->persist($rule);
                $this->getDoctrine()->getEntityManager()->flush();

                $success = true;
            }else{
                $rule = clone $provider->getRule();
                $rule->setRequestData($request);

                if(serialize($rule) != serialize($provider->getRule())){
                    $provider->setRuleId($rule->getId());
                    $provider->setRule($rule);

                    $this->getDoctrine()->getEntityManager()->persist($rule);
                    $this->getDoctrine()->getEntityManager()->persist($provider);
                    $this->getDoctrine()->getEntityManager()->flush();

                    $success = true;
                }
            }
        }

        return new JsonResponse(array('success' => $success));
    }
}