<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use MyHotelService\Entities\Reservations;

use Ofat\SilexJWT\JWTAuth;
use Ofat\SilexJWT\Middleware\JWTTokenCheck;

class ReservationsController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // On récupère tous les utilisateurs
        $controllers->get('/reservations', [$this, 'getAllReservations']);

        // On récupère un utilisateur selon un id
        $controllers->get('/reservation/{reservation_id}', [$this, 'getReservationById']);

        // On crée un utilisateur
        $controllers->post('/hotel/{hotel_id}/room/{room_id}/reservation', [$this, 'createReservation']);

        // On crée un utilisateur
        // $controllers->get('/user/validate/{email}', [$this, 'validateAccount']);

        return $controllers;
    }

    /**
     * Récupère tous les hotels
     *
     * @param Application $app Silex Application
     *
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllReservations(Application $app, Request $request)
    {
        $all_reservations = $app["repositories"]("Reservations")->findAll();

        return $app->json($all_reservations, 200);
    }

    /**
     * Récupère un reservation selon son id
     *
     * @param Application $app Silex Application
     * @param integer     $reservation_id id de la reservation
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getReservationById(Application $app, $hotel_id)
    {
        $reservation = $app["repositories"]("Reservations")->findOneById($hotel_id);

        return $app->json($reservation, 200);
    }

    /*
     ----- Prototype de body de requete -----
     {
     }
    */
    public function createReservation(Application $app, Request $req)
    {
        $datas = $req->request->all();

        $reservation = new Reservations();

        $reservation->setProperties($datas);

        $app["orm.em"]->persist($reservation);
        $app["orm.em"]->flush();

        return $app->json($reservation, 200);
    }
}
