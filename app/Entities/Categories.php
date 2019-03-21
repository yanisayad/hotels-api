<?php

namespace MyHotelService\Entities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MyHotelService\Utils\Doctrine\AutoIncrementId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="MyHotelService\Repositories\CategoriesRepository")
 * @Table(name="Categories")
 */
class Categories implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="string", name="type ", length=45, nullable=false)
     */
    protected $type;

    /**
     * @Column(type="integer", name="people")
     */
    protected $people;

    /**
     * @Column(type="string", name="informations", length=45, nullable=false)
     */
    protected $informations;

    /**
     * @Column(type="float", name="price")
     */
    protected $price;


        // /**
        //  * @OneToMany(targetEntity="Reservations", mappedBy="hotel")
        //  */
        // protected $reservations;

        // public function __construct()
        // {
        //     $this->reservations = new ArrayCollection();
        // }


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
     * Gets the value of type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets the value of people.
     *
     * @return integer
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Gets the value of informations.
     *
     * @return string
     */
    public function getInformations()
    {
        return $this->informations;
    }

    /**
     * Gets the value of price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    // /**
    //  * Gets the value of hotel.
    //  *
    //  * @return Hotels
    //  */
    // public function getHotel()
    // {
    //     return $this->hotel;
    // }

    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Sets the value of type.
     *
     * @param string $type the type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Sets the value of people.
     *
     * @param integer $people the people
     *
     * @return self
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Sets the value of informations.
     *
     * @param string $informations the informations
     *
     * @return self
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;

        return $this;
    }

    /**
     * Sets the value of price.
     *
     * @param float $price the price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    // /**
    //  * Sets the value of hotel.
    //  *
    //  * @param Hotels $hotel the hotel
    //  *
    //  * @return self
    //  */
    // public function setHotel($hotel)
    // {
    //     $this->hotel = $hotel;

    //     return $this;
    // }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"           => $this->getId(),
            "type"         => $this->getType(),
            "people"       => $this->getPeople(),
            "informations" => $this->getinformations(),
            "price"        => $this->getPrice(),
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
            "type",
            "people",
            "informations",
            "hotel"
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
