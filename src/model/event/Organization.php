<?php

namespace model\event;

use lib\util\Object;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="event_organization")
 */
class Organization extends Object
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;
    /** @Column(type="string") */
    private $name;
    /** @Column(type="string") */
    private $city;
    /** @Column(type="string") */
    private $state;
    /**
     * @OneToMany(targetEntity="model\event\CertificateTemplate", mappedBy="organization", cascade={"remove"})    
     * @OrderBy({"name" = "ASC"})
     */
    private $certificateTemplates;

    function __construct()
    {
        $this->certificateTemplates = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    function getCertificateTemplates()
    {
        return $this->certificateTemplates;
    }

    function setCertificateTemplates($certificateTemplates)
    {
        $this->certificateTemplates = $certificateTemplates;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
}