<?php

namespace MyHotelService\Entities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MyHotelService\Utils\Doctrine\AutoIncrementId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="MyHotelService\Repositories\RoomsRepository")
 * @Table(name="Rooms")
 */
class Rooms implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @ManyToOne(targetEntity="Hotels", inversedBy="rooms")
     * @JoinColumn(name="hotel_id", referencedColumnName="id")
     */
    protected $hotel;

    /**
     * @OneToOne(targetEntity="Categories")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @OneToMany(targetEntity="Reservations", mappedBy="hotel")
     */
    protected $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

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
     * Gets the value of category.
     *
     * @return Categories
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Gets the value of hotel.
     *
     * @return Hotels
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Sets the value of category.
     *
     * @param Categories $category the category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Sets the value of hotel.
     *
     * @param Hotels $hotel the hotel
     *
     * @return self
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"       => $this->getId(),
            "category" => $this->getCategory(),
            "hotel"    => $this->getHotel()
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
            "category",
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
