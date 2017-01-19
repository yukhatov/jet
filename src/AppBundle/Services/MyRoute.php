<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 13.10.16
 * Time: 16:18
 */

namespace AppBundle\Services;


class MyRoute
{
    private $webRoot;

    public function __construct($rootDir)
    {
        $this->webRoot = realpath($rootDir . '/../web');
    }

    public function getBasePath()
    {
        return $this->webRoot;
    }
}