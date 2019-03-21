<?php

namespace MyHotelService\Entities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MyHotelService\Utils\Doctrine\AutoIncrementId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="MyHotelService\Repositories\UsersRepository")
 * @Table(name="Users")
 */
class Users implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="string", name="login", length=45, nullable=false)
     */
    protected $login;

    /**
     * @Column(type="string", name="email", length=45, nullable=false)
     */
    protected $email;

    /**
     * @Column(type="string", name="password", length=45, nullable=false)
     */
    protected $password;

    /**
     * @Column(type="string", name="firstname", length=45, nullable=false)
     */
    protected $firstname;

    /**
     * @Column(type="string", name="lastname", length=45, nullable=false)
     */
    protected $lastname;

    /**
     * @Column(type="string", name="address", length=45, nullable=false)
     */
    protected $address;

    /**
     * @Column(type="string", name="city", length=45, nullable=false)
     */
    protected $city;

    /**
     * @Column(type="integer", name="zipcode", length=45, nullable=false)
     */
    protected $zipcode;

    /**
     * @Column(type="boolean", name="is_admin", length=45, nullable=false)
     */
    protected $is_admin;

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
     * Gets the value of firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Gets the value of lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Gets the value of address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Gets the value of city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Gets the value of zipcode.
     *
     * @return integer
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Gets the value of is_admin.
     *
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
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
     * Sets the value of firstname.
     *
     * @param string $firstname the firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Sets the value of lastname.
     *
     * @param string $lastname the lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Sets the value of address.
     *
     * @param string $address the address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Sets the value of city.
     *
     * @param string $city the city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Sets the value of is_admin.
     *
     * @param string $is_admin the is_admin
     *
     * @return self
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    /**
     * Sets the value of zipcode.
     *
     * @param string $zipcode the zipcode
     *
     * @return self
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "firstname" => $this->getFirstname(),
            "lastname"  => $this->getLastname(),
            "login"     => $this->getLogin(),
            "email"     => $this->getEmail(),
            "address"   => $this->getAddress(),
            "city"      => $this->getCity(),
            "zipcode"   => $this->getZipcode(),
            "is_admin"  => $this->getIsAdmin()
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
            "firstname",
            "lastname",
            "password",
            "login",
            "email",
            "address",
            "city",
            "zipcode"
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
