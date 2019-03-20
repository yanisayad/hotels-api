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
     * @ManyToOne(targetEntity="Rooms", inversedBy="reservations")
     * @JoinColumn(name="room_id", referencedColumnName="id")
     */
    protected $room;

    /**
     * @OneToOne(targetEntity="Users")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @Column(type="integer", name="has_parking")
     */
    protected $has_parking;

    /**
     * @Column(type="integer", name="has_baby_bed")
     */
    protected $has_baby_bed;

    /**
     * @Column(type="integer", name="has_romance_pack")
     */
    protected $has_romance_pack;

    /**
     * @Column(type="integer", name="has_breakfast")
     */
    protected $has_breakfast;


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
     * Gets the value of room.
     *
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Gets the value of user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Gets the value of has_parking.
     *
     * @return integer
     */
    public function getHasParking()
    {
        return $this->has_parking;
    }

    /**
     * Gets the value of has_baby_bed.
     *
     * @return integer
     */
    public function getHasBabyBed()
    {
        return $this->has_baby_bed;
    }

    /**
     * Gets the value of has_romance_pack.
     *
     * @return integer
     */
    public function getHasRomancePack()
    {
        return $this->has_romance_pack;
    }

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getHasBreakfast()
    {
        return $this->has_breakfast;
    }


    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Gets the value of room.
     *
     * @return Room
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Gets the value of user.
     *
     * @return User
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets the value of has_parking.
     *
     * @return integer
     */
    public function setHasParking($has_parking)
    {
        $this->has_parking = $has_parking;

        return $this;
    }

    /**
     * Gets the value of has_baby_bed.
     *
     * @return integer
     */
    public function setHasBabyBed($has_baby_bed)
    {
        $this->has_baby_bed = $has_baby_bed;

        return $this;
    }

    /**
     * Gets the value of has_romance_pack.
     *
     * @return integer
     */
    public function setHasRomancePack($has_romance_pack)
    {
        $this->has_romance_pack = $has_romance_pack;

        return $this;
    }

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function setHasBreakfast($has_breakfast)
    {
        $this->has_breakfast = $has_breakfast;

        return $this;
    }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"               => $this->getId(),
            "hotel"            => $this->getRoom()->getHotel(),
            "room"             => $this->getRoom(),
            "has_parking"      => $this->getHasParking(),
            "has_baby_bed"     => $this->getHasBabyBed(),
            "has_romance_pack" => $this->getHasRomancePack(),
            "has_breakfast"    => $this->getHasBreakfast()
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
            "hotel",
            "room",
            "has_parking",
            "has_baby_bed",
            "has_romance_pack",
            "has_breakfast"
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
