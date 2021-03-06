<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.01.17
 * Time: 14:22
 */
namespace AppBundle\Controller;

use AppBundle\Entity\InventoryItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrdersReportController extends Controller
{
    /**
     * @Route("/ordersReport", name="ordersReport")
     */
    public function detailedAction()
    {
        $ydayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y')) - 86400;
        $todayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y'));

        $reports = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findSummaryByDateRange($ydayMidnight, $todayMidnight);

        $ordersCount = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->getOrdersCountByDateRange($ydayMidnight, $todayMidnight);

        return $this->render('report/ordersReport.html.twig', ['reports' => $reports, 'ordersCount' => $ordersCount, 'defaultDates' => ['from' => date("Y-m-d", $ydayMidnight), 'to' => date("Y-m-d", $ydayMidnight)]]);
    }

    /**
     * @Route("/ordersReportTableData", options={"expose"=true}, name="ordersReportTableData")
     */
    public function ordersReportDataAction(Request $request)
    {
        $get = $request->query->all();

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->findByParamsSerialized($get);

        $items = $this->relateInventoryItems($items);

        $itemsTotalCount = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->getTotalCount();

        $itemsTotalByParamsCount = $this->getDoctrine()
            ->getRepository('AppBundle:OrderItem')
            ->getTotalCountByParams($get);

        $output = array(
            "draw" =>  intval($get['draw']),
            "recordsTotal" => $itemsTotalCount,
            "recordsFiltered" => $itemsTotalByParamsCount,
            "data" => $items,
            "requestParameters" => $get,
        );

        return new JsonResponse($output);
    }

    private function relateInventoryItems($items){
        foreach ($items as $item) {
            $inventoryItem = $this->getDoctrine()
                ->getRepository('AppBundle:InventoryItem')
                ->findSerializedOneBy(['sku' => $item->merchantSku]);

            if($inventoryItem)
            {
                $item->inventory = $inventoryItem;

                if($inventoryItem->wholePrice != 0)
                {
                    $item->inventory->clearIncome = $item->clearOrderPrice - $inventoryItem->wholePrice;
                    $item->inventory->incomePercentage = round($item->inventory->clearIncome / $inventoryItem->wholePrice, 2) * 100 . '%';
                }else{
                    $item->inventory->clearIncome = '<b>unknown</b>';
                    $item->inventory->incomePercentage = '<b>unknown</b>';
                }
            }else{
                $item->inventory = InventoryItem::getEmpty();
            }
        }

        return $items;
    }
}