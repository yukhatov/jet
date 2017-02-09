<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 11.11.16
 * Time: 10:33
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\InventoryItem;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Rule;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadInventoryItemData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rule = $this->newRule($manager);

        $provider = $this->newProvider($manager, $rule);
        $brand = $this->newBrand($manager, $provider);

        $this->newInventoryItem($manager, 'D378333', $brand);
        $this->newInventoryItem($manager, 'D378334', $brand);
        $this->newInventoryItem($manager, 'D378335', $brand);
    }

    private function newRule(ObjectManager $manager)
    {
        $rule = new Rule();
        $rule->setId(0);

        $manager->persist($rule);
        $manager->flush();

        return $rule;
    }

    private function newInventoryItem(ObjectManager $manager, $sku, Brand $brand)
    {
        $item = new InventoryItem();
        $item->setTitle('Ray Ban RB 3300');
        $item->setBrandName($brand->getTitle());
        $item->setBrand($brand);
        $item->setProvider($brand->getProvider());
        $item->setProviderId($brand->getProvider()->getId());
        $item->setColorCode('030');
        $item->setColorTitle('Tortoise');
        $item->setCreated(1479704400);
        $item->setPrice(99.9);
        $item->setProviderName('Luxotica');
        $item->setSku($sku);
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

    private function newProvider(ObjectManager $manager, Rule $rule)
    {
        $provider = new Provider();
        $provider->setTitle('Luxotica');
        $provider->setId(3);
        $provider->setRule($rule);
        $provider->setRuleId($rule->getId());

        $manager->persist($provider);
        $manager->flush();

        return $provider;
    }

    private function newBrand(ObjectManager $manager, Provider $provider)
    {
        $brand = new Brand();
        $brand->setTitle('Ray-Ban');
        $brand->setId(85);
        $brand->setProviderId($provider->getId());
        $brand->setProvider($provider);

        $manager->persist($brand);
        $manager->flush();

        return $brand;
    }
}