<?php

namespace model\event;

use lib\util\Object;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use model\user\User;

/**
 * @Entity
 * @Table(name="event")
 */
class Event extends Object
{

    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    /**
     * @ManyToOne(targetEntity="model\event\Organization", cascade={"merge"})
     * @JoinColumn(name="organization_id", referencedColumnName="id")
     */
    private $organization;

    /** @Column(type="text", nullable=true) */
    private $description;

    /** @Column(type="date") */
    private $startDate;

    /** @Column(type="date") */
    private $endDate;

    /** @Column(type="string") */
    private $address;

    /**
     * @OneToMany(targetEntity="model\event\Activity", mappedBy="event", cascade={"remove"})
     * @OrderBy({"name" = "ASC"})
     */
    private $activities;

    /** @Column(type="boolean") */
    private $isOpen;

    /** @Column(type="boolean") */
    private $isRegistrationOpen;

    /**
     * @ManyToMany(targetEntity="model\user\User")
     * @JoinTable(name="event_participant")
     * @OrderBy({"name" = "ASC"})
     * @var ArrayCollection
     */
    private $participants;

    /**
     * @ManyToMany(targetEntity="model\user\User")
     * @JoinTable(name="event_participant_confirmed")
     * @OrderBy({"id" = "ASC"})
     * @var ArrayCollection
     */
    private $confirmed;

    public function __construct()
    {
        $this->isOpen = true;
        $this->participants = new ArrayCollection;
        $this->confirmed = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOrganization()
    {
        return $this->organization;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartDate()
    {
        if (!empty($this->startDate)) {
            return $this->startDate->format('d/m/Y');
        }
    }

    public function getStartDateUS()
    {
        if (!empty($this->startDate)) {
            return $this->startDate->format('Y-m-d');
        }
    }

    public function getEndDate()
    {
        if (!empty($this->endDate)) {
            return $this->endDate->format('d/m/Y');
        }
    }

    public function getEndDateUS()
    {
        if (!empty($this->endDate)) {
            return $this->endDate->format('Y-m-d');
        }
    }

    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getActivities()
    {
        return $this->activities;
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

    public function setOrganization($organization)
    {
        $this->organization = $organization;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = date_create_from_format('Y-m-d', $startDate);
        return $this;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = date_create_from_format('Y-m-d', $endDate);
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setActivities($activities)
    {
        $this->activities = $activities;
        return $this;
    }

    public function getIsOpen()
    {
        return $this->isOpen;
    }

    public function setIsOpen($isOpen)
    {
        $this->isOpen = $isOpen;
        return $this;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;
        return $this;
    }

    public function getConfirmed()
    {
        return $this->confirmed;
    }

    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    public function isConfirmed(User $user)
    {
        return $this->confirmed->contains($user);
    }

    function getIsRegistrationOpen()
    {
        return $this->isRegistrationOpen;
    }

    function setIsRegistrationOpen($isRegistrationOpen)
    {
        $this->isRegistrationOpen = $isRegistrationOpen;
        return $this;
    }

    function getFullDate()
    {
        if ($this->startDate->format('Y') !== $this->endDate->format('Y')) {
            return sprintf("%s de %s de %s a %s de %s de %s"
                    , $this->startDate->format('d')
                    , \lib\util\Date::MesNome($this->startDate->format('m'))
                    , $this->startDate->format('Y')
                    , $this->endDate->format('d')
                    , \lib\util\Date::MesNome($this->endDate->format('m'))
                    , $this->endDate->format('Y'));
        } else if ($this->startDate->format('m') !== $this->endDate->format('m')) {
            return sprintf("%s de %s a %s de %s de %s"
                    , $this->startDate->format('d')
                    , \lib\util\Date::MesNome($this->startDate->format('m'))
                    , $this->endDate->format('d')
                    , \lib\util\Date::MesNome($this->endDate->format('m'))
                    , $this->endDate->format('Y'));
        } else {
            return sprintf("%s a %s de %s de %s"
                    , $this->startDate->format('d')
                    , $this->endDate->format('d')
                    , \lib\util\Date::MesNome($this->endDate->format('m'))
                    , $this->endDate->format('Y'));
        }
    }

}
