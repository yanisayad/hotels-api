<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use MyHotelService\Entities\Rooms;

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

        // On récupère tous les utilisateurs
        $controllers->get('/rooms', [$this, 'getAllRooms']);

        // On récupère un utilisateur selon un id
        $controllers->get('/room/{room_id}', [$this, 'getRoomById']);

        // On crée un utilisateur
        $controllers->post('/room', [$this, 'createRoom']);

        // On crée un utilisateur
        // $controllers->get('/user/validate/{email}', [$this, 'validateAccount']);

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
    public function getAllRooms(Application $app, Request $request)
    {
        // $token = substr($request->headers->get('authorization'), 7);
        // $test = $app['jwt_auth']->getPayload($token);
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

    /*
     ----- Prototype de body de requete -----
     {
     }
    */
    public function createHotel(Application $app, Request $req)
    {
        $datas = $req->request->all();

        $room = new Hotels();

        $room->setProperties($datas);
        $room->setPassword(sha1($datas["password"]));
        $room->setLatitude($datas["lat"]);
        $room->setLongitude($datas["lng"]);
        $room->setIsActive(true);
        $app["orm.em"]->persist($room);
        $app["orm.em"]->flush();

        return $app->json($room, 200);
    }
}
