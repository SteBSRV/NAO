<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Observartion
 *
 * @Vich\Uploadable
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
     * @var DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    protected $date;
    
    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_observe", type="integer")
     */
    protected $nbObserved;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="Address", cascade={"all", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $address;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="Taxref")
     * @ORM\JoinColumn(name="bird", referencedColumnName="id", nullable=true)
     */
    protected $bird;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    protected $image = '5943b32b391e5.png'; // Image par défaut (dossier uploads/images/observations/)

    /** 
     * @var File
     *
     * @Vich\UploadableField(mapping="observations_images", fileNameProperty="image", nullable=true)
     */
    private $imageFile;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    protected $state;

    /**
     * @ORM\OneToMany(targetEntity="UserObservation", mappedBy="observation", cascade={"persist"})
     */
    private $userObservation;


    public function __construct()
    {
        
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Observation
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Observation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set nbObserved
     *
     * @param string $nbObserved
     *
     * @return Observation
     */
    public function setNbObserved($nbObserved)
    {
        $this->nbObserved = $nbObserved;

        return $this;
    }

    /**
     * Get nbObserved
     *
     * @return string
     */
    public function getNbObserved()
    {
        return $this->nbObserved;
    }

    /**
     * Set address
     *
     * @param \stdClass $address
     *
     * @return Observation
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \stdClass
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Observation
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set bird
     *
     * @param \stdClass $bird
     *
     * @return Observation
     */
    public function setBird(Taxref $bird)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \stdClass
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Observation
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imageFile
     *
     * @param File $image
     *
     * @return Oberservation
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if($image) {
            $this->date = new \DateTime("now");
        }

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Observation
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add userObservation
     *
     * @param \AppBundle\Entity\UserObservation $userObservation
     *
     * @return Observation
     */
    public function addUserObservation(\AppBundle\Entity\UserObservation $userObservation)
    {
        $this->userObservation[] = $userObservation;

        return $this;
    }

    /**
     * Remove userObservation
     *
     * @param \AppBundle\Entity\UserObservation $userObservation
     */
    public function removeUserObservation(\AppBundle\Entity\UserObservation $userObservation)
    {
        $this->userObservation->removeElement($userObservation);
    }

    /**
     * Get userObservation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserObservation()
    {
        return $this->userObservation;
    }
}
