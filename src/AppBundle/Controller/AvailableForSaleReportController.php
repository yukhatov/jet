<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 04.01.17
 * Time: 17:03
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AvailableForSaleReportController extends Controller
{
    /**
     * @Route("/afs", name="afs")
     */
    public function indexAction()
    {
        $reports = $this->getDoctrine()
            ->getRepository('AppBundle:ReportAfs')
            ->findAll();

        return $this->render('report/afs.html.twig', ['reports' => $reports]);
    }
}