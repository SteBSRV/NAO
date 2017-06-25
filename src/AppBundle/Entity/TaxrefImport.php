<?php

namespace AppBundle\Entity;

class TaxrefImport
{
    protected $attachement;

    public function getAttachement()
    {
        return $this->attachement;
    }

    public function setAttachement($attachement)
    {
        $this->attachement = $attachement;

        return $this;
    }
}
