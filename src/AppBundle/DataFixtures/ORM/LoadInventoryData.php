<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 11.11.16
 * Time: 10:33
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\InventoryItem;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadInventoryItemData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->newInventoryItem($manager);
    }

    private function newInventoryItem(ObjectManager $manager)
    {
        $item = new InventoryItem();
        $item->setTitle('Ray Ban RB 3300');
        $item->setBrandName('Ray-Ban');
        $item->setColorCode('030');
        $item->setColorTitle('Tortoise');
        $item->setCreated(1479704400);
        $item->setPrice(99.9);
        $item->setProviderName('Luxotica');
        $item->setSku('D378333');
        $item->setWholePrice(66.6);
        $item->setStockCount(2);
        $item->setFjStatus('Created');
        $item->setFjSubStatus('success');
        $item->setDescription('Ray Ban RB 3300');
        $item->setUpc(751286228656);
        $item->setSize1('');
        $item->setSize2('');
        $item->setSize3('');

        $manager->persist($item);
        $manager->flush();
    }
}