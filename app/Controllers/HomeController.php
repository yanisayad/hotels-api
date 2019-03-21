<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use MyHotelService\Entities\Users;

use Ofat\SilexJWT\JWTAuth;
use Ofat\SilexJWT\Middleware\JWTTokenCheck;

class HomeController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // Page d'accueil
        $controllers->get('/', [$this, 'home']);

        return $controllers;
    }

    /**
     * Home page
     *
     * @param Application $app Silex Application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function home(Application $app)
    {
        return $app->json("home", 200);
    }

}
