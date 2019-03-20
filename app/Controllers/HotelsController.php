<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use MyHotelService\Entities\Hotels;

use Ofat\SilexJWT\JWTAuth;
use Ofat\SilexJWT\Middleware\JWTTokenCheck;

class HotelsController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // On récupère tous les utilisateurs
        $controllers->get('/hotels', [$this, 'getAllHotels']);

        // On récupère un utilisateur selon un id
        $controllers->get('/hotel/{hotel_id}', [$this, 'getHotelById']);

        // On crée un utilisateur
        $controllers->post('/hotel', [$this, 'createHotel']);

        // On crée un utilisateur
        // $controllers->get('/room/validate/{email}', [$this, 'validateAccount']);

        return $controllers;
    }

    /**
     * Récupère tous les hotels
     *
     * @param Application $app Silex Application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllHotels(Application $app, Request $request)
    {
        $all_hotels = $app["repositories"]("Hotels")->findAll();

        return $app->json($all_hotels, 200);
    }

    /**
     * Récupère un hotel selon son id
     *
     * @param Application $app Silex Application
     * @param integer     $hotel_id id de l'hotel
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getHotelById(Application $app, $hotel_id)
    {
        $room = $app["repositories"]("Hotels")->findOneById($hotel_id);

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

        $hotel = new Hotels();

        $hotel->setProperties($datas);

        $app["orm.em"]->persist($hotel);
        $app["orm.em"]->flush();

        return $app->json($hotel, 200);
    }

}
