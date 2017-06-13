<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observartion
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    protected $date;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var object
     *
     * @ORM\Column(name="adress", type="object")
     * @ORM\OneToOne(targetEntity="Adress")
     * @ORM\JoinColumn(name="adress_id", referencedColumnName="id")
     */
    protected $adress;

    /**
     * @var object
     *
     * @ORM\Column(name="user", type="object")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var object
     *
     * @ORM\Column(name="bird", type="object")
     * @ORM\ManyToOne(targetEntity="Bird")
     * @ORM\JoinColumn(name="bird_id", referencedColumnName="id")
     */
    protected $bird;

    /**
     * @var object
     *
     * @ORM\Column(name="photo", type="object")
     * @ORM\ManyToOne(targetEntity="Photo")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     */
    protected $photo;

    public function __construct()
    {

    }
}
