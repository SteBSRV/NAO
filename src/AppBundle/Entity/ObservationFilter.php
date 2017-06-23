<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Taxref;
class ObservationFilter
{
    /**
     * @var text
     *
     */
    protected $bird;

    /**
     * @var int
     *
     */
    protected $dateSince;

    /**
     * @var text
     *
     */
    protected $region;

    /**
     * @var text
     *
     */
    protected $city;

    /**
     * @var boolean
     *
     */
    protected $popularity;

    /**
     * @var int
     *
     */
    protected $nbObserved;

    public function __construct()
    {

    }

    /**
     * Get bird
     *
     * @return String
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set bird
     *
     * @param String $bird
     *
     * @return ObservationFilter
     */
    public function setBird(Taxref $bird)
    {
        $this->bird = $bird->getNomver();

        return $this;
    }

    /**
     * Get dateSince
     *
     * @return integer
     */
    public function getDateSince()
    {
        return $this->dateSince;
    }

    /**
     * Set dateSince
     *
     * @param integer $dateSince
     *
     * @return ObservationFilter
     */
    public function setDateSince($dateSince)
    {
        $this->dateSince = $dateSince;

        return $this;
    }

    /**
     * Get region
     *
     * @return String
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set region
     *
     * @param String $region
     *
     * @return ObservationFilter
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get city
     *
     * @return String
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param String $city
     *
     * @return ObservationFilter
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get popularity
     *
     * @return boolean
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set popularity
     *
     * @param boolean $popularity
     *
     * @return ObservationFilter
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get nbObserved
     *
     * @return int
     */
    public function getNbObserved()
    {
        return $this->nbObserved;
    }

    /**
     * Set nbObserved
     *
     * @param String $nbObserved
     *
     * @return ObservationFilter
     */
    public function setNbObserved($nbObserved)
    {
        $this->nbObserved = $nbObserved;

        return $this;
    }

    public function toArray()
    {
        $array = [
            'bird' => $this->getBird(),
            'dateSince' => $this->getDateSince(),
            'region' => $this->getRegion(),
            'city' => $this->getCity(),
            'popularity' => $this->getPopularity(),
            'nbObserved' => $this->getNbObserved(),
        ];

        return $array;
    }
}
