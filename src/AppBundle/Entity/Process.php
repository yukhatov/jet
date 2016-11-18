<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 16.11.16
 * Time: 12:21
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_process")
 */

class Process
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $action;

    /**
     * @ORM\Column(type="time", name="timeStart")
     */
    private $timeStart;

    /**
     * @ORM\Column(type="datetime", name="timeLastAccess", nullable=true)
     */
    private $timeLastAccess;

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
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $name
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * @param mixed $timeStart
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;
    }

    /**
     * @return mixed
     */
    public function getTimeLastAccess()
    {
        return $this->timeLastAccess;
    }

    /**
     * @param mixed $timeLastAccess
     */
    public function setTimeLastAccess($timeLastAccess)
    {
        $this->timeLastAccess = $timeLastAccess;
    }

    public function isRunNeeded()
    {
        $now = new \DateTime();
        $now->setDate(1970, 1, 1);
        $todayMidnight = mktime(0, 0, 0, date('n'), date('j'),date('Y'));

        if($this->getTimeStart()->getTimeStamp() <= $now->getTimestamp() and  ( !$this->getTimeLastAccess() or $this->getTimeLastAccess()->getTimeStamp() <= $todayMidnight ))
        {
            return true;
        }
    }
}