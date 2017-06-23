<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NewsLetter
 *
 * @ORM\Table(name="news_letter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsLetterRepository")
 */
class NewsLetter
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
     * @var String
     * @Assert\Type("string")
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var String
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $mail;

    public function __construct ($name, $email)
    {
        $this->setName($name);
        $this->setMail($email);

        return $this;
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
     * Set name
     *
     * @param string $name
     *
     * @return NewsLetter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return NewsLetter
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
}
