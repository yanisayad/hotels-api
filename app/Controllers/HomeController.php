<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

class HomeController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // On récupère tous les utilisateurs
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
