<?php

namespace model\event\activity;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="event_activity_session")
 */
class Session extends Object
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;
    /**
     * @Column(type="date")
     * @var \DateTime
     */
    private $date;
    /**
     * @Column(type="time") 
     * @var \DateTime
     */
    private $start;
    /**
     * @Column(type="time") 
     * @var \DateTime
     */
    private $end;
    /**
     * @ManyToOne(targetEntity="model\event\Activity", inversedBy="sessions", cascade={"persist", "merge"})
     * @JoinColumn(name="activity_id", referencedColumnName="id")
     * @var \model\event\Activity
     */
    private $activity;

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function getDate()
    {
        return $this->date->format('Y-m-d');
    }

    function getDateStr()
    {
        return $this->date->format('d/m/Y');
    }

    function getStart($timestamp = false)
    {
        if ($timestamp) {
            return $this->start->getTimestamp();
        }
        return $this->start->format('H:i');
    }
    
    function getStartTime() {
        return $this->start;
    }

    function getEnd($timestamp = false)
    {
        if ($timestamp) {
            return $this->end->getTimestamp();
        }
        return $this->end->format('H:i');
    }
    
    function getEndTime() {
        return $this->end;
    }

    function setDate($date)
    {
        $this->date = date_create_from_format('Y-m-d', $date);
        return $this;
    }

    function setStart($start)
    {
        $this->start = date_create_from_format('H:i', $start);
        return $this;
    }

    function setEnd($end)
    {
        $this->end = date_create_from_format('H:i', $end);
        return $this;
    }

    function getActivity()
    {
        return $this->activity;
    }

    function setActivity(\model\event\Activity $activity)
    {
        $this->activity = $activity;
        return $this;
    }
}