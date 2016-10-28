<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 26.10.16
 * Time: 17:08
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_actions")
 */

class Action
{
    public function __construct($orderId, $actionType, Status $status = null)
    {
        if($status){
            $actionBody = ['acknowledgement_status' => $status->getStatus(), 'order_id' => $orderId];
        }else{
            $actionBody = ['order_id' => $orderId];
        }

        $this->setActionBody(json_encode($actionBody));
        $this->setActionClass($actionType);
        $this->setCharterer('frontEndAdmin');
        $this->setCreated(time());
        $this->setLastUpdate(time());
        $this->setStatus('created');
        $this->setTimeToStart(time() + 10);
        $this->setResultLogId(0);
        $this->setServiceStartTime(0);
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $charterer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action_class;

    /**
     * @ORM\Column(type="integer")
     */
    private $created;

    /**
     * @ORM\Column(type="integer")
     */
    private $last_update;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $time_to_start;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action_body;

    /**
     * @ORM\Column(type="integer")
     */
    private $result_log_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $service_start_time;

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
    public function getCharterer()
    {
        return $this->charterer;
    }

    /**
     * @param mixed $charterer
     */
    public function setCharterer($charterer)
    {
        $this->charterer = $charterer;
    }

    /**
     * @return mixed
     */
    public function getActionClass()
    {
        return $this->action_class;
    }

    /**
     * @param mixed $action_class
     */
    public function setActionClass($action_class)
    {
        $this->action_class = $action_class;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTimeToStart()
    {
        return $this->time_to_start;
    }

    /**
     * @param mixed $time_to_start
     */
    public function setTimeToStart($time_to_start)
    {
        $this->time_to_start = $time_to_start;
    }

    /**
     * @return mixed
     */
    public function getActionBody()
    {
        return $this->action_body;
    }

    /**
     * @param mixed $action_body
     */
    public function setActionBody($action_body)
    {
        $this->action_body = $action_body;
    }

    /**
     * @return mixed
     */
    public function getResultLogId()
    {
        return $this->result_log_id;
    }

    /**
     * @param mixed $result_log_id
     */
    public function setResultLogId($result_log_id)
    {
        $this->result_log_id = $result_log_id;
    }

    /**
     * @return mixed
     */
    public function getServiceStartTime()
    {
        return $this->service_start_time;
    }

    /**
     * @param mixed $service_start_time
     */
    public function setServiceStartTime($service_start_time)
    {
        $this->service_start_time = $service_start_time;
    }


}