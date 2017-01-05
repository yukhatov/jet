<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 05.01.17
 * Time: 16:02
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jet_report_afs")
 */
class ReportAfs
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="provider_title")
     */
    private $providerTitle;

    /**
     * @ORM\Column(type="string", name="brand_title")
     */
    private $brandTitle;

    /**
     * @ORM\Column(type="integer", name="all")
     */
    private $totalCount;

    /**
     * @ORM\Column(type="integer", name="instock_count")
     */
    private $instockCount;

    /**
     * @ORM\Column(type="integer", name="outstock_count")
     */
    private $outstockCount;

    /**
     * @ORM\Column(type="integer", name="under_jet_review_count")
     */
    private $underJetReviewCount;

    /**
     * @ORM\Column(type="integer", name="afs_count")
     */
    private $afsCount;

    /**
     * @ORM\Column(type="integer", name="excluded_count")
     */
    private $excludedCount;

    /**
     * @ORM\Column(type="integer", name="missing_data_count")
     */
    private $missingDataCount;

    /**
     * @return mixed
     */
    public function getProviderTitle()
    {
        return $this->providerTitle;
    }

    /**
     * @param mixed $providerTitle
     */
    public function setProviderTitle($providerTitle)
    {
        $this->providerTitle = $providerTitle;
    }

    /**
     * @return mixed
     */
    public function getBrandTitle()
    {
        return $this->brandTitle;
    }

    /**
     * @param mixed $brandTitle
     */
    public function setBrandTitle($brandTitle)
    {
        $this->brandTitle = $brandTitle;
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param mixed $totalCount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return mixed
     */
    public function getInstockCount()
    {
        return $this->instockCount;
    }

    /**
     * @param mixed $instockCount
     */
    public function setInstockCount($instockCount)
    {
        $this->instockCount = $instockCount;
    }

    /**
     * @return mixed
     */
    public function getOutstockCount()
    {
        return $this->outstockCount;
    }

    /**
     * @param mixed $outstockCount
     */
    public function setOutstockCount($outstockCount)
    {
        $this->outstockCount = $outstockCount;
    }

    /**
     * @return mixed
     */
    public function getUnderJetReviewCount()
    {
        return $this->underJetReviewCount;
    }

    /**
     * @param mixed $underJetReviewCount
     */
    public function setUnderJetReviewCount($underJetReviewCount)
    {
        $this->underJetReviewCount = $underJetReviewCount;
    }

    /**
     * @return mixed
     */
    public function getAfsCount()
    {
        return $this->afsCount;
    }

    /**
     * @param mixed $afsCount
     */
    public function setAfsCount($afsCount)
    {
        $this->afsCount = $afsCount;
    }

    /**
     * @return mixed
     */
    public function getExcludedCount()
    {
        return $this->excludedCount;
    }

    /**
     * @param mixed $excludedCount
     */
    public function setExcludedCount($excludedCount)
    {
        $this->excludedCount = $excludedCount;
    }

    /**
     * @return mixed
     */
    public function getMissingDataCount()
    {
        return $this->missingDataCount;
    }

    /**
     * @param mixed $missingDataCount
     */
    public function setMissingDataCount($missingDataCount)
    {
        $this->missingDataCount = $missingDataCount;
    }

}