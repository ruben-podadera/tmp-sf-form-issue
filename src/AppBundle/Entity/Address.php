<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    protected $id;

    /*
     * @Assert\NotBlank()
     */
    protected $zipCode;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
}
