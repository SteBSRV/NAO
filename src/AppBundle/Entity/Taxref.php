<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxref
 *
 * @ORM\Table(name="taxref")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefRepository")
 */
class Taxref
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
     * @ORM\Column(name="nom_de_reference", type="string", length=255)
     */
    protected $nomRef;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_vernaculaire", type="string", length=255, nullable=true)
     */
    protected $nomVer;

    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=255)
     */
    protected $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255)
     */
    protected $famille;

    /**
     * @var int
     *
     * @ORM\Column(name="reference", type="integer")
     */
    protected $reference;

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
     * Set nomRef
     *
     * @param string $nomRef
     *
     * @return Taxref
     */
    public function setNomRef($nomRef)
    {
        $this->nomRef = $nomRef;

        return $this;
    }

    /**
     * Get nomRef
     *
     * @return string
     */
    public function getNomRef()
    {
        return $this->nomRef;
    }

    /**
     * Set nomVer
     *
     * @param string $nomVer
     *
     * @return Taxref
     */
    public function setNomVer($nomVer)
    {
        $this->nomVer = $nomVer;

        return $this;
    }

    /**
     * Get nomVer
     *
     * @return string
     */
    public function getNomVer()
    {
        return $this->nomVer;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Taxref
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Taxref
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Taxref
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference()
    {
        return $this->reference;
    }
}
