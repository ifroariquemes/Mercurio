<?php

namespace model\event\activity;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="event_activity_type_translation")
 */
class Translation extends Object
{
    /** @Column(type="string") */
    private $name;

    /** @id @Column(type="string") */
    private $language;

    /**
     * @id
     * @ManyToOne(targetEntity="model\event\activity\Type", inversedBy="translations", cascade={"persist", "merge"})
     * @JoinColumn(name="activity_type_id", referencedColumnName="id")
     */
    private $type;

    function getName()
    {
        return $this->name;
    }

    function getLanguage()
    {
        return $this->language;
    }

    function getType()
    {
        return $this->type;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}