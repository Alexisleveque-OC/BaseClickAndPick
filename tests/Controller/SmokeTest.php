<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     * @param $pageName
     * @param $url
     * @param string $method
     * @param int $expectedStatusCode
     * @param null $loggedAs
     */
    public function testPageIsSuccessful($pageName,
                                         $url,
                                         $method = "GET",
                                         $expectedStatusCode = 200,
                                         $loggedAs = null)
    {
        $client = self::createClient();
        if ($loggedAs) {
            $userRepository = static::$container->get(UserRepository::class);
            $testUser = $userRepository->findOneBy(['username' => $loggedAs]);
            $client->loginUser($testUser);
        }

        $client->request($method, $url);
        $response = $client->getResponse();

        self::assertSame(
            $response->getStatusCode(),
            $expectedStatusCode
        );
    }

    public function provideUrls()
    {
        yield['home', '/'];
        yield['home', '/', 'GET', 200, 'Admin'];
        yield['home', '/', 'GET', 200, 'User1'];
        yield['login', '/login'];
        yield['login', '/login', 'GET', 200, 'Admin'];
        yield['login', '/login', 'GET', 200, 'User1'];
        yield['logout', '/logout', 'GET', 302];
        yield['logout', '/logout', 'GET', 302, 'Admin'];
        yield['logout', '/logout', 'GET', 302, 'User1'];
        yield['user_forgot_pass', 'users/forgotpass', 'GET', 200];
        yield['user_forgot_pass', 'users/forgotpass', 'GET', 302, 'Admin'];
        yield['user_forgot_pass', 'users/forgotpass', 'GET', 302, 'User1'];
        yield['users_registration', 'users/registration', 'GET', 200];
        yield['users_registration', 'users/registration', 'GET', 302, 'Admin'];
        yield['users_registration', 'users/registration', 'GET', 302, 'User1'];
        yield['user_reset_pass', 'users/reset-pass/123456789', 'GET', 200];
        yield['user_reset_pass', 'users/reset-pass/123456789', 'GET', 302, 'Admin'];
        yield['user_reset_pass', 'users/reset-pass/987654321', 'GET', 302, 'User1'];
        yield['user_validation', 'users/validation/123456789', 'GET', 200];
        yield['user_validation', 'users/validation/123456789', 'GET', 302, 'Admin'];
        yield['user_validation', 'users/validation/987654321', 'GET', 302, 'User1'];
        yield['menu_management', 'menu/management', 'GET', 302];
        yield['menu_management', 'menu/management', 'GET', 200, 'Admin'];
        yield['menu_management', 'menu/management', 'GET', 403, 'User1'];
        yield['meal_create', 'meals/create', 'GET', 302];
        yield['meal_create', 'meals/create', 'GET', 200, 'Admin'];
        yield['meal_create', 'meals/create', 'GET', 403, 'User1'];
    }

}