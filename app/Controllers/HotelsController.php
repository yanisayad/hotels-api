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
        $controllers->put('/hotel/{hotel_id}', [$this, 'updateHotel']);

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
        $hotel = $app["repositories"]("Hotels")->findOneById($hotel_id);

        return $app->json($hotel, 200);
    }

    /**
     * Modifie un hotel existant
     *
     * @param Application $app Silex Application
     * @param integer     $hotel_id id de l'hotel
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateHotel(Application $app, Request $req, $hotel_id)
    {
        $hotel = $app["repositories"]("Hotels")->findOneById($hotel_id);

        if ($hotel === null) {
            return $app->abort(404, "Hotel {$hotel_id} doesnt exist.");
        }

        $name    = $req->request->get("name", null);
        $website = $req->request->get("website", null);

        if (in_array(null, [$name, $website])) {
            return $app->abort(400, "Bad field provided");
        }

        $hotel->setName($name);
        $hotel->setWebsite($website);

        $app["orm.em"]->persist($hotel);
        $app["orm.em"]->flush();

        return $app->json($hotel, 200);
    }


    /**
     * Creation d'un hotel
     *
     * @param Application $app Silex Application
     * @param Request     $req Request
     * @param integer     $hotel_id id de l'hotel
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    /*
     ----- Prototype de body de requete -----
     {
            "name",
            "website",
            "address",
            "city",
            "zipcode"
     }
    */
    public function createHotel(Application $app, Request $req)
    {
        $data = $req->request->all();

        $hotel = new Hotels();

        $hotel->setProperties($data);

        $app["orm.em"]->persist($hotel);
        $app["orm.em"]->flush();

        return $app->json($hotel, 200);
    }

}
