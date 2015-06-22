<?php

namespace model\event\activity;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="event_activity_type")
 */
class Type extends Object
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    /**
     * @OneToMany(targetEntity="model\event\activity\Translation", mappedBy="type", cascade={"persist"})    
     * @OrderBy({"language" = "ASC"})
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
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

    function getTranslations()
    {
        return $this->translations;
    }

    function setTranslations($translations)
    {
        $this->translations = $translations;
        return $this;
    }
    
    public function getTranslation($language) {
        foreach($this->translations as $t) {
            if($t->getLanguage() == $language) {
                return $t->getName();
            }
        }
        return $this->name;
    }
    
    public function addTranslation(Translation $t) {
        $this->translations->add($t);
    }        
}