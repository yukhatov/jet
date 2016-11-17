<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 16.11.16
 * Time: 15:11
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Process;

class ProcessController extends Controller
{
    /**
     * @Route("/check", name="check")
     */
    public function checkAction()
    {
        $processes = $this->getDoctrine()
            ->getRepository('AppBundle:Process')
            ->findAll();

        foreach ($processes as $process) {
            if ($process->isRunNeeded()) {
                $this->updateTime($process);

                $action = $process->getAction();
                $this->$action();
            }
        }

        return new Response();
    }

    public function updateBrand()
    {
        echo "\n";
        print_r('update');
        die('stop');
    }

    private function updateTime(Process $process)
    {
        $date = new \DateTime();
        $date->setTimestamp(time());
        $date->format('Y-m-d H:i:s');

        $process->setTimeLastAccess($date);

        $this->getDoctrine()->getEntityManager()->persist($process);
        $this->getDoctrine()->getEntityManager()->flush();
    }
}