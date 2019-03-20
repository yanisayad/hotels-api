<?php

use Silex\Application;
use Symfony\Component\HttpKernel\Tests\Controller;

Use MyHotelService\Entities\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    private $app;
    public function __construct()
    {
        $this->app = new Silex\Application();
    }

    public function testGetAllUsers()
    {
        $app = new Silex\Application();
        $application_env = getenv("APPLICATION_ENV") ? : null;
        $app->register(new MyHotelService\Config($application_env));

        $controller = new MyHotelService\Controllers\UserController;
        $this->assertEquals(true, 0 < count($controller->getAllUsers($app)));
    }

    public function testGetUserById()
    {
        $app = new Silex\Application();
        $application_env = getenv("APPLICATION_ENV") ? : null;
        $app->register(new MyHotelService\Config($application_env));

        $controller = new MyHotelService\Controllers\UserController;

        $result = (array) (json_decode($controller->getUserById($app, 1)->getContent()));
        $this->assertArrayHasKey('id', $result);

        $this->assertEquals($result["id"], 1);
    }
}
