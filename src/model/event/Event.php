<?php

namespace model\event;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="event")
 */
class Event extends Object {

    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    /**
     * @ManyToOne(targetEntity="model\organization\Organization", cascade={"merge"})
     * @JoinColumn(name="organization_id", referencedColumnName="id")     
     * @Input(type="select")
     */
    private $organization;

    /** @Column(type="string", nullable=true) */
    private $description;

    /** @Column(type="date") */
    private $startDate;

    /** @Column(type="date") */
    private $endDate;

    /** @Column(type="string") */
    private $address;

    /**
     * @OneToMany(targetEntity="model\activity\Activity", mappedBy="event")    
     */
    private $activities;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getOrganization() {
        return $this->organization;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStartDate() {
        if (!empty($this->startDate)) {
            return $this->startDate->format('d/m/Y');
        }
    }

    public function getStartDateUS() {
        if (!empty($this->startDate)) {
            return $this->startDate->format('Y-m-d');
        }
    }

    public function getEndDate() {
        if (!empty($this->endDate)) {
            return $this->endDate->format('d/m/Y');
        }
    }

    public function getEndDateUS() {
        if (!empty($this->endDate)) {
            return $this->endDate->format('Y-m-d');
        }
    }

    public function getAddress() {
        return $this->address;
    }

    public function getActivities() {
        return $this->activities;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setOrganization($organization) {
        $this->organization = $organization;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = date_create_from_format('Y-m-d', $startDate);
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = date_create_from_format('Y-m-d', $endDate);
        return $this;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function setActivities($activities) {
        $this->activities = $activities;
        return $this;
    }

}
