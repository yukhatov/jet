<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 13.10.16
 * Time: 16:18
 */

namespace AppBundle\Services;

//require (__DIR__ . '/../../../../jet_api/jetmain.php');

class JetApi
{
    public $var;

    public function __construct($var = 0)
    {
        $this->var = $var;
    }

    public function getAllOrders()
    {
        $controll = new \jetApiOrders();
        $orders = $controll->getAllOrders();

        return $orders;
    }
}