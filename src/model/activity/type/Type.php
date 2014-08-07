<?php

namespace model\activity\type;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="activity_type")
 */
class Type extends Object {

    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}
