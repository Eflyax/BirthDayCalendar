<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine;
use Nette\Security\Passwords;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 */
class User extends Doctrine\Entities\BaseEntity
{
    const ROLE_ADMIN = 'admin';

    use Doctrine\Entities\Attributes\Identifier;

    /** @ORM\Column(type="string", length=100) */
    protected $password;

    /** @ORM\Column(unique=TRUE, type="string", length=100) */
    protected $email;

    /** @ORM\Column(type="enum", columnDefinition="enum('admin') NOT NULL") */
    protected $role = self::ROLE_ADMIN;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $name;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $surname;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $phone;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $photo;

    public function setPassword($password)
    {
        $this->password = Passwords::hash($password);
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }



}
