<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 16.11.16
 * Time: 15:11
 */

namespace AppBundle\Controller;

ini_set('max_execution_time', '9999999');

use AppBundle\Entity\Brand;
use AppBundle\Entity\Provider;
use AppBundle\Entity\ReportInstock;
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

                if(method_exists(new ProcessController(), $action))
                {
                    $this->$action();
                }else{
                    echo "\n";
                    print_r('Undefined action!');
                }
            }
        }

        return new Response();
    }

    private function reportInstock()
    {
        $today = new \DateTime();
        $today->setTimestamp(time());
        $today->format('Y-m-d');

        $this->getDoctrine()->getEntityManager()->clear();

        $brands = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->findAll();

        foreach ($brands as $brand) {
            $instockCount = 0;
            $outstockCount = 0;

            foreach ($brand->getInventoryItems()->toArray() as $item) {
                    if($item->getStockCount()){
                        $instockCount += 1;
                    }else{
                        $outstockCount += 1;
                    }
            }

            $report = $this->getDoctrine()
                ->getRepository('AppBundle:ReportInstock')
                ->findOneBy(['time' => $today, 'brand_id' => $brand->getId()]);
            //если за сегодня репорт уже есть, то обновляем
            if($report){
                $report->setInstockCount($instockCount);
                $report->setOutstockCount($outstockCount);
            }else{
                $report = new ReportInstock($brand, $instockCount, $outstockCount);
            }

            $this->getDoctrine()->getEntityManager()->persist($report);
            $this->getDoctrine()->getEntityManager()->flush();
        }
    }

    private function updateBrandAndProvider(){
        if($this->updateProvider()){
            $this->updateBrand();
        }
    }

    private function updateBrand()
    {
        $result = false;

        $connection = $this->get('database_connection');
        $amzBrands = $connection->fetchAll('SELECT * FROM amz_glasses_brand');

        if(count($amzBrands)){
            //sync with amz brands
            foreach ($amzBrands as $abKey => $brand)
            {
                if (isset($brand['brand_id']) and isset($brand['provider_id']) and isset($brand['brand_title'])) {

                    $jetBrand = $this->getDoctrine()
                        ->getRepository('AppBundle:Brand')
                        ->find($brand['brand_id']);

                    $provider = $this->getDoctrine()
                        ->getRepository('AppBundle:Provider')
                        ->find($brand['provider_id']);

                    if ($provider) {
                        if ($jetBrand) {
                            $jetBrand->setTitle($brand['brand_title']);
                            $jetBrand->setProviderId($brand['provider_id']);
                            $jetBrand->setProvider($provider);
                        } else {
                            $jetBrand = new Brand();
                            $jetBrand->setId($brand['brand_id']);
                            $jetBrand->setTitle($brand['brand_title']);
                            $jetBrand->setProviderId($brand['provider_id']);
                            $jetBrand->setProvider($provider);
                        }

                        $this->getDoctrine()->getEntityManager()->persist($jetBrand);
                        $this->getDoctrine()->getEntityManager()->flush();
                    }else{
                        continue;
                    }
                }
            }

            $result = true;
        }

        return $result;
    }

    private function updateProvider()
    {
        $result = false;

        $connection = $this->get('database_connection');
        $amzProviders = $connection->fetchAll('SELECT * FROM amz_glasses_provider');

        if(count($amzProviders)) {
            //sync with amz providers
            foreach ($amzProviders as $apKey => $provider)
            {
                if (isset($provider['provider_id']) and isset($provider['provider_title'])) {
                    $jetProvider = $this->getDoctrine()
                        ->getRepository('AppBundle:Provider')
                        ->find($provider['provider_id']);

                    if($jetProvider)
                    {
                        $jetProvider->setId($provider['provider_id']);
                        $jetProvider->setTitle($provider['provider_title']);
                    }else{
                        $jetProvider = new Provider();
                        $jetProvider->setId($provider['provider_id']);
                        $jetProvider->setTitle($provider['provider_title']);
                    }

                    $this->getDoctrine()->getEntityManager()->persist($jetProvider);
                    $this->getDoctrine()->getEntityManager()->flush();
                }
            }

            $result = true;
        }

        return $result;
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