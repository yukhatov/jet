<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 14.11.16
 * Time: 12:06
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_order_status")
 */

class OrderStatus{

    const STATUS_CREATED = 'created';
    const STATUS_READY = 'ready';
    const STATUS_ACKNOWLEDGED = 'acknowledged';
    const STATUS_IN_PROGRESS = 'inprogress';
    const STATUS_COMPLETE = 'complete';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED_BY_MERCHANT = 'completed by merchant';
    const STATUS_CANCELED = 'canceled';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}