<?php


namespace App\Tests\Service\User;


use App\Entity\Address;
use App\Entity\Token;
use App\Entity\User;
use App\Service\User\RegisterService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterServiceTest extends TestCase
{
    /**
     * @var RegisterService
     */
    private RegisterService $RegisterService;

    public function setUp()
    {
        $manager = $this->createMock(EntityManagerInterface::class);
        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $encoder->method('encodePassword')
            ->willReturn('hash');
        $this->RegisterService = new RegisterService($encoder, $manager);
    }

    public function userProvider()
    {
        $address = new Address();
        $address->setAddress('1 rue du coucou')
            ->setCity('paris')
            ->setZipCode(75000);
        $user = new User();
        $user->setUsername('toto');
        $user->setPassword('coucou');
        $user->setEmail("toto@toto.com")
        ->setAddress($address);

        $address->setUser($user);


        return [[$user]];
    }

    /**
     * @dataProvider userProvider
     * @param User $user
     */
    public function testRegisterUser(User $user)
    {
        $test = $this->RegisterService->register($user);

        $this->assertEquals($test->getUser()->getUsername(), 'toto');
        $this->assertEquals($test->getUser()->getRoles()[0], 'ROLE_USER');
        $this->assertEquals(16, strlen($test->getToken()));
        $this->assertInstanceOf(Token::class, $test);
        $this->assertInstanceOf(User::class, $test->getUser());
    }

}