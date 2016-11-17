<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.11.16
 * Time: 12:01
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\OrderStatus;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrderStatusData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->newStatus($manager, 'Created', 'created');
        $this->newStatus($manager, 'Ready', 'ready');
        $this->newStatus($manager, 'Acknowledged', 'acknowledged');
        $this->newStatus($manager, 'In progress', 'inprogress');
        $this->newStatus($manager, 'Complete', 'complete');
        $this->newStatus($manager, 'Rejected', 'rejected');
    }

    private function newStatus(ObjectManager $manager, $title, $statusCode){
        $status = new OrderStatus();
        $status->setTitle($title);
        $status->setStatus($statusCode);

        $manager->persist($status);
        $manager->flush();
    }
}