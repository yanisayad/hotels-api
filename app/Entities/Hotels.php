<?php

namespace MyHotelService\Entities;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MyHotelService\Utils\Doctrine\AutoIncrementId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="MyHotelService\Repositories\HotelsRepository")
 * @Table(name="Hotels")
 */
class Hotels implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="string", name="name", length=45, nullable=false)
     */
    protected $name;

    /**
     * @Column(type="string", name="website", length=45, nullable=false)
     */
    protected $website;

    /**
     * @OneToMany(targetEntity="Rooms", mappedBy="hotel")
     */
    protected $rooms;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
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
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the value of website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Gets the value of rooms.
     *
     * @return ArrayCollections
     */
    public function getRooms()
    {
        $rooms = $this->rooms->toArray();

        if (empty($rooms)) {
            return null;
        }
        $hotel_rooms = array_map(
            function ($child) {
                return [
                    "id"           => $child->getId(),
                    "name"         => $child->getName(),
                    "people"       => $child->getPeople(),
                    "informations" => $child->getinformations(),
                    "price"        => $child->getPrice(),
                ];
            },
            $rooms
        );
        return $hotel_rooms;
    }

    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the value of website.
     *
     * @param string $website the website
     *
     * @return self
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }


    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "name"      => $this->getName(),
            "website"   => $this->getWebsite()
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
            "name",
            "website"
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
