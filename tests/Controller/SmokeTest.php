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
        yield['homepage', '/'];
        yield['homepage', '/', 'GET', 200, 'Admin'];
        yield['homepage', '/', 'GET', 200, 'User1'];
        yield['login', '/login'];
        yield['login', '/login', 'GET', 200, 'Admin'];
        yield['login', '/login', 'GET', 200, 'User1'];
        yield['logout', '/logout', 'GET', 302];
        yield['logout', '/logout', 'GET', 302, 'Admin'];
        yield['logout', '/logout', 'GET', 302, 'User1'];
        yield['users/forgotpass', 'users/forgotpass', 'GET', 200];
        yield['users/forgotpass', 'users/forgotpass', 'GET', 302, 'Admin'];
        yield['users/forgotpass', 'users/forgotpass', 'GET', 302, 'User1'];
        yield['users/registration', 'users/registration', 'GET', 200];
        yield['users/registration', 'users/registration', 'GET', 302, 'Admin'];
        yield['users/registration', 'users/registration', 'GET', 302, 'User1'];
        yield['users/reset-pass/{token}', 'users/reset-pass/123456789', 'GET', 200];
        yield['users/reset-pass/{token}', 'users/reset-pass/123456789', 'GET', 302, 'Admin'];
        yield['users/reset-pass/{token}', 'users/reset-pass/987654321', 'GET', 302, 'User1'];
        yield['users/validtation/{token}', 'users/validation/123456789', 'GET', 200];
        yield['users/validtation/{token}', 'users/validation/123456789', 'GET', 302, 'Admin'];
        yield['users/validtation/{token}', 'users/validation/987654321', 'GET', 302, 'User1'];
    }

}