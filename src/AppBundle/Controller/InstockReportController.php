<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 15.11.16
 * Time: 16:40
 */
namespace AppBundle\Controller;

use AppBundle\Entity\ReportInstock;
use AppBundle\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Request;

class InstockReportController extends Controller
{
    private $providerId;
    private $brandId;
    private $fromDate;
    private $toDate;

    /**
     * @Route("/instock/{from}/{to}/{providerId}/{brandId}", options={"expose"=true}, name="instock",
     *      requirements={"from": "\d{4}-\d{1,2}-\d{1,2}", "to": "\d{4}-\d{1,2}-\d{1,2}", "providerId": "\d+", "brandId": "\d+"})
     */
    public function indexAction($from = 0, $to = 0, $providerId = 0, $brandId = 0)
    {
        $params = $this->getParameters($from, $to, $providerId, $brandId);

        $providers = $this->getDoctrine()
            ->getRepository('AppBundle:Provider')
            ->findAll();

        $brands = $this->getDoctrine()
            ->getRepository('AppBundle:Brand')
            ->find($brandId);

        if($providerId)
        {
            $brands = $this->getDoctrine()
                ->getRepository('AppBundle:Brand')
                ->findBy(['providerId' => $providerId]);
        }

        return $this->render('report/instock.html.twig', ['chart' => $this->getChart(), 'providers' => $providers, 'brands' => $brands, 'params' => $params]);
    }

    private function getParameters($from, $to, $providerId, $brandId){
        $this->providerId = $providerId;
        $this->brandId = $brandId;

        if(!$from and !$to)
        {
            $this->fromDate = date("Y-m-d", time() - 604800); //last week by default
            $this->toDate = date("Y-m-d", time());
        }else{
            $this->fromDate = $from;
            $this->toDate = $to;
        }

        return ['selectedProvider' => $this->providerId,
                'selectedBrand' => $this->brandId,
                'startDate' => $this->fromDate,
                'endDate' => $this->toDate];
    }

    private function getChart()
    {
        $chartData = $this->getChartData();
        $series = $chartData['series'];
        $categories = $chartData['categories'];

        $chart = new Highchart();
        $chart->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $chart->title->text('Instock Chart');
        $chart->xAxis->title(array('text'  => "Date"));
        $chart->yAxis->title(array('text'  => "Count"));
        $chart->plotOptions->line(array(
            'dataLabels'    => array('enabled' => true),
        ));
        $chart->xAxis->categories($categories);
        $chart->series($series);

        return $chart;
    }

    private function getChartData()
    {
        $series = array();
        $categories = array();
        $providers = array();

        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:ReportInstock');

        if($this->providerId)
        {
            if($this->brandId)
            {
                $query = $repository->createQueryBuilder('r')
                    ->where('r.time >= :fromDate')
                    ->andWhere('r.time <= :toDate')
                    ->andWhere('r.brand_id = :brandId')
                    ->setParameters(['fromDate' => $this->fromDate, 'toDate' => $this->toDate, 'brandId' => $this->brandId])
                    ->getQuery();

                $reports = $query->getResult();
            }else{
                $query = $repository->createQueryBuilder('r')
                    ->where('r.time >= :fromDate')
                    ->andWhere('r.time <= :toDate')
                    ->andWhere('r.provider_id = :providerId')
                    ->setParameters(['fromDate' => $this->fromDate, 'toDate' => $this->toDate, 'providerId' => $this->providerId])
                    ->getQuery();

                $reports = $query->getResult();
            }
        }else{
            $query = $repository->createQueryBuilder('r')
                ->where('r.time >= :fromDate')
                ->andWhere('r.time <= :toDate')
                ->setParameters(['fromDate' => $this->fromDate, 'toDate' => $this->toDate])
                ->getQuery();

            $reports = $query->getResult();
        }

        if($reports)
        {
            foreach ($reports as $report) {
                if(!array_key_exists($report->getProviderId(), $providers))
                {
                    $providers[$report->getProviderId()]['categories'][$report->getTime()->format('Y-m-d')] = $report->getInstockCount();
                    $providers[$report->getProviderId()]['title'] = $report->getProvider()->getTitle();
                }else{
                    if(array_key_exists($report->getTime()->format('Y-m-d'), $providers[$report->getProviderId()]['categories']))
                    {
                        $providers[$report->getProviderId()]['categories'][$report->getTime()->format('Y-m-d')] += $report->getInstockCount();
                    }else{
                        $providers[$report->getProviderId()]['categories'][$report->getTime()->format('Y-m-d')] = $report->getInstockCount();
                    }
                }
            }

            $categories = array_keys(current($providers)['categories']);

            foreach ($providers as $provider) {
                $series[] = ['name' => $provider['title'], 'data' => array_values($provider['categories'])];
            }
        }

        return ['categories' => $categories, 'series' => $series];
    }
}