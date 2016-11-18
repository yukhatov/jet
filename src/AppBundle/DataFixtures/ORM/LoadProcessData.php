<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 17.11.16
 * Time: 14:20
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Process;

class LoadProcessData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->newProcess($manager, 'updateBrand');
        $this->newProcess($manager, 'updateProvider');
    }

    private function newProcess(ObjectManager $manager, $action){
        $time = new \DateTime();
        $time->setDate(1970, 1, 1);
        $time->setTime(14, 00, 00);

        $process = new Process();
        $process->setAction($action);
        $process->setTimeStart($time);

        $manager->persist($process);
        $manager->flush();
    }
}