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
     * @Column(type="datetime", name="date_start")
     */
    protected $date_start;

    /**
     * @Column(type="datetime", name="date_end")
     */
    protected $date_end;

    /**
     * @Column(type="boolean", name="has_parking")
     */
    protected $has_parking;

    /**
     * @Column(type="boolean", name="has_baby_bed")
     */
    protected $has_baby_bed;

    /**
     * @Column(type="boolean", name="has_romance_pack")
     */
    protected $has_romance_pack;

    /**
     * @Column(type="boolean", name="has_breakfast")
     */
    protected $has_breakfast;

    /**
     * @Column(type="float", name="final_price")
     */
    protected $final_price;

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
     * @return boolean
     */
    public function getHasParking()
    {
        return $this->has_parking;
    }

    /**
     * Gets the value of has_baby_bed.
     *
     * @return boolean
     */
    public function getHasBabyBed()
    {
        return $this->has_baby_bed;
    }

    /**
     * Gets the value of has_romance_pack.
     *
     * @return boolean
     */
    public function getHasRomancePack()
    {
        return $this->has_romance_pack;
    }

    /**
     * Gets the value of has_breakfast.
     *
     * @return boolean
     */
    public function getHasBreakfast()
    {
        return $this->has_breakfast;
    }

    /**
     * Gets the value of date_start.
     *
     * @return datetime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Gets the value of date_end.
     *
     * @return datetime
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Gets the value of final_price.
     *
     * @return float
     */
    public function getFinalPrice()
    {
        return $this->final_price;
    }

    /**************************************/
    /* ------------ SETTERS ------------ */
    /**************************************/

    /**
     * Sets the value of room.
     *
     * @param Room $room the room
     *
     * @return self
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Sets the value of user.
     *
     * @param User $user the user
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Sets the value of date_start.
     *
     * @param DateTime $date_start the date_start
     *
     * @return self
     */
    public function setDateStart(\DateTime $date_start)
    {
        $this->date_start = $date_start;

        return $this;
    }

    /**
     * Sets the value of date_end.
     *
     * @param DateTime $date_end the date_end
     *
     * @return self
     */
    public function setDateEnd(\DateTime $date_end)
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * Sets the value of has_parking.
     *
     * @param boolean $has_parking the has_parking
     *
     * @return self
     */
    public function setHasParking($has_parking)
    {
        $this->has_parking = $has_parking;

        return $this;
    }

    /**
     * Sets the value of has_baby_bed.
     *
     * @param boolean $has_baby_bed the has_baby_bed
     *
     * @return self
     */
    public function setHasBabyBed($has_baby_bed)
    {
        $this->has_baby_bed = $has_baby_bed;

        return $this;
    }

    /**
     * Sets the value of has_romance_pack.
     *
     * @param boolean $has_romance_pack the has_romance_pack
     *
     * @return self
     */
    public function setHasRomancePack($has_romance_pack)
    {
        $this->has_romance_pack = $has_romance_pack;

        return $this;
    }

    /**
     * Sets the value of has_breakfast.
     *
     * @param boolean $has_breakfast the has_breakfast
     *
     * @return self
     */
    public function setHasBreakfast($has_breakfast)
    {
        $this->has_breakfast = $has_breakfast;

        return $this;
    }

    /**
     * Sets the value of final_price.
     *
     * @param boolean $final_price the final_price
     *
     * @return self
     */
    public function setFinalPrice($final_price)
    {
        $this->final_price = $final_price;

        return $this;
    }

    /**************************************/
    /* ------------ Utils ------------ */
    /**************************************/

    public function toArray()
    {
        return [
            "id"               => $this->getId(),
            "room"             => $this->getRoom(),
            "start"            => $this->getDateStart(),
            "end"              => $this->getDateEnd(),
            "has_parking"      => $this->getHasParking(),
            "has_baby_bed"     => $this->getHasBabyBed(),
            "has_romance_pack" => $this->getHasRomancePack(),
            "has_breakfast"    => $this->getHasBreakfast(),
            "final_price"      => $this->getFinalPrice()
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
            "start",
            "end",
            "has_parking",
            "has_baby_bed",
            "has_romance_pack",
            "has_breakfast",
            "final_price"
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
