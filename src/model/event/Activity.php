<?php

namespace model\event;

use lib\util\Object;
use model\user\User;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="event_activity")
 */
class Activity extends Object
{

    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    /**
     * @ManyToOne(targetEntity="model\event\Event", inversedBy="activities", cascade={"merge"})
     * @JoinColumn(name="event_id", referencedColumnName="id")
     * @var Event
     */
    private $event;

    /**
     * @ManyToOne(targetEntity="model\event\activity\Type", cascade={"merge"})
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /** @Column(type="string") */
    private $duration;

    /** @Column(type="text") */
    private $description;

    /** @Column(type="array") */
    private $speakers = array();

    /**
     * @ManyToMany(targetEntity="model\user\User", inversedBy="activities")
     * @JoinTable(name="event_activity_participant")
     * @OrderBy({"name"="ASC"})
     */
    private $participants;

    /**
     * @ManyToMany(targetEntity="model\user\User", inversedBy="activities")
     * @JoinTable(name="event_activity_present")   
     */
    private $present;

    /** @Column(type="boolean") */
    private $hasCertificate;

    /** @Column(type="boolean") */
    private $hasSubmissions;

    /** @Column(type="integer") */
    private $vacancies;

    /**
     * @OneToMany(targetEntity="model\event\activity\Session", mappedBy="activity", cascade={"persist","remove"})    
     * @OrderBy({"date" = "ASC", "start" = "ASC"})
     * @var ArrayCollection
     */
    private $sessions;

    /** @Column(type="array") */
    private $disable = array();
    private $confirmed;
    private $participantNotConfirmed;

    public function __construct()
    {
        $this->type = new activity\Type;
        $this->participants = new ArrayCollection;
        $this->present = new ArrayCollection;
        $this->sessions = new ArrayCollection;
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

    /**
     * @return \model\event\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    public function getPresent()
    {
        return $this->present;
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

    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function setSpeakers($speakers)
    {
        $this->speakers = $speakers;
        return $this;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;
        return $this;
    }

    public function setPresent($present)
    {
        $this->present = $present;
        return $this;
    }

    public function getHasCertificate()
    {
        return $this->hasCertificate;
    }

    public function getHasSubmissions()
    {
        return $this->hasSubmissions;
    }

    public function setHasCertificate($hasCertificate)
    {
        $this->hasCertificate = $hasCertificate;
        return $this;
    }

    public function setHasSubmissions($hasSubmissions)
    {
        $this->hasSubmissions = $hasSubmissions;
        return $this;
    }

    public function addSpeaker($name)
    {
        array_push($this->speakers, $name);
    }

    public function addParticipant(User $user)
    {
        array_push($this->participants, $user);
    }

    public function getVacancies()
    {
        return $this->vacancies;
    }

    public function setVacancies($vacancies)
    {
        $this->vacancies = $vacancies;
        return $this;
    }

    public function hasVacancy()
    {
        return (empty($this->vacancies) || ($this->vacancies > count($this->participants)));
    }

    public function remainingVacancies()
    {
        return (empty($this->vacancies)) ? 'Unlimited' : $this->vacancies - count($this->participants);
    }

    public function getConfirmed()
    {
        if (is_null($this->confirmed)) {
            $this->confirmed = new ArrayCollection;
            if (count($this->participants)) {
                foreach ($this->participants as $participant) {
                    if ($this->getEvent()->getConfirmed()->contains($participant)) {
                        $this->confirmed->add($participant);
                    }
                }
            }
        }
        return $this->confirmed->count();
    }

    /**
     * @return ArrayCollection
     */
    function getSessions()
    {
        return $this->sessions;
    }

    function setSessions($sessions)
    {
        $this->sessions = $sessions;
        return $this;
    }

    function addSession(activity\Session $session)
    {
        $this->sessions->add($session);
        return $this;
    }

    function getDisable()
    {
        return $this->disable;
    }

    function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    function getParticipantsNotConfirmed()
    {
        $this->getConfirmed();
        if (is_null($this->participantNotConfirmed)) {
            $this->participantNotConfirmed = new ArrayCollection();
            foreach ($this->participants as $participant) {
                if (is_null($this->confirmed) || !$this->confirmed->contains($participant)) {
                    $this->participantNotConfirmed->add($participant);
                }
            }
        }
        return $this->participantNotConfirmed;
    }

}
