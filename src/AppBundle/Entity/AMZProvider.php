<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10.10.16
 * Time: 13:45
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="amz_glasses_provider")
 */

class AMZProvider {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $provider_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider_title;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->provider_id;
    }

    /**
     * @return mixed
     */
    public function getProviderTitle()
    {
        return $this->provider_title;
    }

    /**
     * @param mixed $provider_title
     */
    public function setProviderTitle($provider_title)
    {
        $this->provider_title = $provider_title;
    }

}