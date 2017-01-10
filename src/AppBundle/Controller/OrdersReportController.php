<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.01.17
 * Time: 14:22
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class OrdersReportController extends Controller
{
    /**
     * @Route("/ordersReport", name="ordersReport")
     */
    public function indexAction()
    {
        $ydayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y')) - 86400;
        $todayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y'));

        $reports = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findByDateRange($ydayMidnight, $todayMidnight);

        /*echo "<pre>";
        print_r($reports);
        die('stop');*/


        return $this->render('report/orders.html.twig', ['reports' => $reports]);
    }
}