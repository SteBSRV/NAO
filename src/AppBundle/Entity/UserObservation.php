<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
/**
 * UserObservation
 *
 * @ORM\Table(name="user_observation",uniqueConstraints={@UniqueConstraint(name="user_observation_unique", columns={"user_id", "observation_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserObservationRepository")
 */
class UserObservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="favoriteObservation", type="boolean")
     */
    private $favoriteObservation;

    /**
     * @ORM\ManyToOne(targetEntity="Observation", inversedBy="userObservation", cascade={"persist"})
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set favoriteObservation
     *
     * @param boolean $favoriteObservation
     *
     * @return UserObservation
     */
    public function setFavoriteObservation($favoriteObservation)
    {
        $this->favoriteObservation = $favoriteObservation;

        return $this;
    }

    /**
     * Get favoriteObservation
     *
     * @return bool
     */
    public function getFavoriteObservation()
    {
        return $this->favoriteObservation;
    }

    /**
     * Set observation
     *
     * @param \AppBundle\Entity\Observation $observation
     *
     * @return UserObservation
     */
    public function setObservation(\AppBundle\Entity\Observation $observation = null)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \AppBundle\Entity\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserObservation
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
