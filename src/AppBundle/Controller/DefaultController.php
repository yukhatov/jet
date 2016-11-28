<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array());
    }

    /**
     * @Route("/admin")
     */
    public function adminAction($productId = 1)
    {
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        return $this->render('default/index.html.twig', array('name' => 'Admin'));
    }
    /**
     * @Route("/providers", name="providers")
     */
    public function providersAction()
    {
        $providers = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findAll();

        return $this->render('default/providers.html.twig', array('providers' => $providers));
    }

    /**
     * @Route("/brands/{provider}", name="brands", requirements={"provider": "\d+"})
     */
    public function brandsAction($provider = null)
    {
        if(!$provider)
        {
            $brands = $this->getDoctrine()
                ->getRepository('AppBundle:Brand')
                ->findAll();
        }else{
            $brands = $this->getDoctrine()
                ->getRepository('AppBundle:Brand')
                ->findBy(['providerId' => $provider]);
        }

        return $this->render('default/brands.html.twig', array('brands' => $brands));
    }
}
