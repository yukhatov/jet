<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.11.16
 * Time: 11:56
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ApproveStatus;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadApproveStatusData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $status = new ApproveStatus();
        $status->setTitle('Accepted');
        $status->setStatus('accepted');

        $manager->persist($status);
        $manager->flush();
    }
}