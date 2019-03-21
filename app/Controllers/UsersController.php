<?php

namespace MyHotelService\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Use MyHotelService\Entities\Users;

use Ofat\SilexJWT\JWTAuth;
use Ofat\SilexJWT\Middleware\JWTTokenCheck;

class UsersController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        // On récupère tous les utilisateurs
        $controllers->get('/users', [$this, 'getAllUsers']);

        // On récupère un utilisateur selon un id
        $controllers->get('/user/{user_id}', [$this, 'getUserById']);

        // On crée un utilisateur
        $controllers->get('/user/validate/{email}', [$this, 'validateAccount']);

        // On crée un utilisateur
        $controllers->post('/user', [$this, 'createUser']);

        return $controllers;
    }

    /**
     * Récupère tous les utilisateurs
     *
     * @param Application $app Silex Application
     *
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllUsers(Application $app, Request $request)
    {
        // $token = substr($request->headers->get('authorization'), 7);
        // $test = $app['jwt_auth']->getPayload($token);
        $all_users = $app["repositories"]("Users")->findAll();

        return $app->json($all_users, 200);
    }

    /**
     * Récupère un utilisateur selon son id
     *
     * @param Application $app Silex Application
     * @param integer $user_id id du user
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUserById(Application $app, $user_id)
    {
        $user = $app["repositories"]("Users")->findOneById($user_id);

        return $app->json($user, 200);
    }

    /**
     * Créer un utilisateur
     *
     * @param Application $app Silex Application
     * @param Request $req Request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */

    /*
     ----- Prototype de body de requete -----
     {
            "firstname",
            "lastname",
            "password
            "login",
            "email",
            "address",
            "city",
            "zipcode",
            "is_admin
     }
    */
    public function createUser(Application $app, Request $req)
    {
        $data = $req->request->all();

        $user = new Users();
        $user->setProperties($data);

        $app["orm.em"]->persist($user);
        $app["orm.em"]->flush();

        return $app->json($user, 200);
    }
}

// public function validateAccount(Application $app, $email)
// {
//     if (($user = $app["repositories"]("Users")->findOneBy(["email" => base64_decode($email)])) === null)
//         $app->abort(404);
//     $user->setIsActive(true);
//     $app["orm.em"]->persist($user);
//     $app["orm.em"]->flush();

//     return $app->redirect($app['app_front']);
// }
