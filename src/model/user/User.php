<?php

namespace model\user;

use lib\util\Object;

/**
 * @Entity
 * @Table(name="user")
 */
class User extends Object
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;

    /** @Column(type="string") */
    private $name;

    /** @Column(type="string") */
    private $password;

    /** @Column(type="string") */
    private $email;

    /** @Column(type="datetime", nullable=true) */
    private $lastLogin;

    /**
     * @ManyToOne(targetEntity="model\user\accountType\AccountType", cascade={"merge"}) 
     * @JoinColumn(name="accountType_id", referencedColumnName="id")
     */
    private $accountType;

    /** @Column(type="string", length=1) */
    private $status;

    /** @Column(type="string", nullable=true) */
    private $code;
    
    /**
     * @ManyToMany(targetEntity="model\event\Activity", mappedBy="participants")
     */
    private $activities;

    function __construct()
    {
        $this->status = '1';
        $this->accountType = new accountType\AccountType;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstName()
    {
        $nameInfo = explode(' ', $this->name);
        return array_shift($nameInfo);
    }

    public function getLastName()
    {
        $nameInfo = explode(' ', $this->name);
        return end($nameInfo);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function getAccountType()
    {
        return $this->accountType;
    }

    public function getStatus()
    {
        return $this->status;
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

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatusStr()
    {
        global $_MyCookie;
        return ($this->status) ?
                $_MyCookie->getTranslation('mycookie', 'status.activated') :
                $_MyCookie->getTranslation('mycookie', 'status.deactivated');
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    public function getActivities() {
        return $this->activities;
    }
}