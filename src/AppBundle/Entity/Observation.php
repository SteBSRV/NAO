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
     * @ORM\Column(name="address", type="object", nullable=true)
     * @ORM\ManyToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     */
    protected $address;

    /**
     * @var object
     *
     * @ORM\Column(name="user", type="object", nullable=true)
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var object
     *
     * @ORM\Column(name="bird", type="object", nullable=true)
     * @ORM\ManyToOne(targetEntity="Taxref")
     * @ORM\JoinColumn(name="bird", referencedColumnName="id", nullable=true)
     */
    protected $bird;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    protected $image;

    /** 
     * @var File
     *
     * @Vich\UploadableField(mapping="observations_images", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    protected $state;



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
    public function setDate($date)
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
    public function setImage(File $image)
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
}
