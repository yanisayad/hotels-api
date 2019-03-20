<?php

namespace MyHotelService\Entities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MyHotelService\Utils\Doctrine\AutoIncrementId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="MyHotelService\Repositories\ReservationsRepository")
 * @Table(name="Reservations")
 */
class Reservations implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="string", name="login", length=45, nullable=false)
     */
    protected $login;

    /**
     * @Column(type="string", name="password", length=45, nullable=false)
     */
    protected $password;

    /**
     * @Column(type="string", name="email", length=45, nullable=false)
     */
    protected $email;

    /**
     * @Column(type="datetime", name="birthdate")
     */
    protected $birthdate;

    /**************************************/
    /* ------------ Getters ------------ */
    /**************************************/
    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Gets the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the value of birthdate.
     *
     * @return string
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Sets the value of login.
     *
     * @param string $login the login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Sets the value of password.
     *
     * @param string $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Sets the value of email.
     *
     * @param string $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Sets the value of birthdate.
     *
     * @param string $birthdate the birthdate
     *
     * @return self
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "login"     => $this->getLogin(),
            "email"     => $this->getEmail(),
            "birthdate" => $this->getBirthdate()
        ];
    }

    public function toIndex()
    {
        return $this->toArray();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function setProperties(array $data)
    {
        $mandatory_fields = [
            "id",
            "login",
            "email",
            "birthdate"
        ];

        $fields = array_intersect(
            $mandatory_fields,
            array_keys($data)
        );

        foreach ($fields as $field) {
            $setterName = 'set' . ucfirst($field);
            if (method_exists($this, $setterName)) {
                $this->{$setterName}($data[$field]);
            }
        }
    }
}
