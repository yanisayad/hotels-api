<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use MyHotelService\Entities\Rooms;
use MyHotelService\Entities\Categories;

use Ofat\SilexJWT\JWTAuth;
use Ofat\SilexJWT\Middleware\JWTTokenCheck;

class RoomsController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // On récupère toutes les chambres
        $controllers->get('/rooms', [$this, 'getAllRooms']);

        // On récupère une chambre selon un id
        $controllers->get('/room/{room_id}', [$this, 'getRoomById']);

        // On crée une chambre
        $controllers->post('hotel/{hotel_id}/category/{category_id}/room', [$this, 'createRoom']);

        $controllers->delete('/room/{room_id}', [$this, 'deleteRoom']);

        return $controllers;
    }

    /**
     * Récupère tous les rooms
     *
     * @param Application $app Silex Application
     *
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllRooms(Application $app)
    {
        $all_rooms = $app["repositories"]("Rooms")->findAll();

        return $app->json($all_rooms, 200);
    }

    /**
     * Récupère un room selon son id
     *
     * @param Application $app Silex Application
     * @param integer     $room_id id de l'room
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRoomById(Application $app, $room_id)
    {
        $room = $app["repositories"]("Rooms")->findOneById($room_id);

        return $app->json($room, 200);
    }

    /**
     * Creer une room
     *
     * @param Application $app Silex Application
     * @param integer     $hotel_id
     * @param integer     $category_id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createRoom(Application $app, $hotel_id, $category_id)
    {
        $hotel    = $app["repositories"]("Hotels")->findOneById($hotel_id);
        $category = $app["repositories"]("Categories")->findOneById($category_id);

        if ($hotel === null) {
            return $app->abort(404, "Hotel {$hotel_id} doesnt exist");
        }
        if ($category === null) {
            return $app->abort(404, "Category doesnt exist");
        }

        $room = new Rooms();
        $room->setHotel($hotel);
        $room->setCategory($category);

        $app["orm.em"]->persist($room);
        $app["orm.em"]->flush();

        return $app->json($room, 200);
    }

    /**
     * Supprimer une room
     *
     * @param Application $app Silex Application
     * @param integer     $room_id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteRoom(Application $app, $room_id)
    {
        $room = $app["repositories"]("Rooms")->findOneById($room_id);

        if (null === $room) {
            return $app->abort(404, "Room {$room_id} not found");
        }

        $app["orm.em"]->remove($room);
        $app["orm.em"]->flush();

        return $app->json("Deleted", 200);

    }
}
