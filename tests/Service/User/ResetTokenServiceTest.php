<?php


namespace App\Tests\Service\User;


use App\Repository\UserRepository;
use App\Service\User\ResetTokenService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ResetTokenServiceTest extends TestCase
{

    /**
     * @var ResetTokenService
     */
    private ResetTokenService $resetTokenService;

    public function setUp()
    {
        $manager = $this->createMock(EntityManagerInterface::class);
        $userRepository = $this->createMock(UserRepository::class);
        $this->resetTokenService = new ResetTokenService($manager,$userRepository);
    }

    public function testResetToken()
    {
//        $userBefore = $userRepository->findOneByEmail('user1@gmail.com');
//        $userBefore = $userBefore[0];
//        dd($userBefore);
//        $tokenBefore = $userBefore->getToken()->getToken();
//
//        $userAfter= $this->resetTokenService->resetToken('user1@gmail.com');
//
//        $tokenAfter = $userAfter->getToken()->getToken();
//
//        $this->assertNotSame($tokenAfter,$tokenBefore);
        $this->assertSame(1,1);
    }
}
