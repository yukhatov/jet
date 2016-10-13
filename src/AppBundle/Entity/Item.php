<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.10.16
 * Time: 14:25
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="amz_glasses_item")
 */

class Item
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */

    private $item_id;
}