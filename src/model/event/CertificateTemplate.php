<?php

namespace model\event;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="event_certificate_template")
 */
class CertificateTemplate extends Object
{
    /** @Id @GeneratedValue @Column(type="integer") */
    private $id;
    /** @Column */
    private $name;
    /**
     * @ManyToOne(targetEntity="model\event\Organization", inversedBy="certificateTemplates", cascade={"merge"})
     * @JoinColumn(name="organization_id", referencedColumnName="id")          
     */
    private $organization;
    /** @Column(type="text") */
    private $speakerFront;
    /** @Column(type="text") */
    private $speakerBack;
    /** @Column(type="text") */
    private $participantFront;
    /** @Column(type="text") */
    private $participantBack;

    function getId()
    {
        return $this->id;
    }

    function getOrganization()
    {
        return $this->organization;
    }

    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function setOrganization($organization)
    {
        $this->organization = $organization;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    function getFront()
    {
        return $this->front;
    }

    function getBack()
    {
        return $this->back;
    }

    function getSpeakerFront()
    {
        return $this->speakerFront;
    }

    function getSpeakerBack()
    {
        return $this->speakerBack;
    }

    function getParticipantFront()
    {
        return $this->participantFront;
    }

    function getParticipantBack()
    {
        return $this->participantBack;
    }

    function setSpeakerFront($speakerFront)
    {
        $this->speakerFront = $speakerFront;
        return $this;
    }

    function setSpeakerBack($speakerBack)
    {
        $this->speakerBack = $speakerBack;
        return $this;
    }

    function setParticipantFront($participantFront)
    {
        $this->participantFront = $participantFront;
        return $this;
    }

    function setParticipantBack($participantBack)
    {
        $this->participantBack = $participantBack;
        return $this;
    }
}