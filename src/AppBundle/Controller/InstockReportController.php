<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 15.11.16
 * Time: 16:40
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InstockReportController extends Controller
{
    /**
     * @Route("/instock", name="instock")
     */
    public function listAction()
    {
        return $this->render('report/instock.html.twig');
    }
}