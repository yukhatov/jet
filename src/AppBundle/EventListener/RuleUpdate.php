<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 02.02.17
 * Time: 17:13
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\Rule;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Product;

class RuleUpdate
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // only act on "Rule" entity
        if (!$entity instanceof Rule) {
            return;
        }

        //$entityManager = $args->getEntityManager();

        $entity->setUpdatedAt(new \DateTime());

    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // only act on "Rule" entity
        if (!$entity instanceof Rule) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());
    }
}