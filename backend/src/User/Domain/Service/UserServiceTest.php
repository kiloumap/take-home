<?php
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Shared\Domain\ValueObject\Email;
use App\User\Application\Request\RegisterUserRequest;
use App\User\Domain\Exception\InvalidCredentialsException;
use App\User\Domain\Exception\PasswordTooShortException;
use App\User\Infrastructure\Persistence\InMemory\Infrastructure\InMemoryUserRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends TestCase
{
    private UserService $service;
    private InMemoryUserRepository $userRepository;

    public function setUp(): void
    {
        $this->userRepository = new InMemoryUserRepository();
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher->method('hashPassword')->willReturn('hashed_password_super_safe');
        $this->service = new UserService($this->userRepository, $passwordHasher);
    }


    public function testRegister(): void
    {
        $this->service->register(new RegisterUserRequest('john.doe@gmail.com', 'superPwd'));
        $users = $this->userRepository->findAll();
        $this->assertCount(1, $users);

        $user = $this->userRepository->findByEmail(new Email('john.doe@gmail.com'));
        $this->assertNotNull($user);
        $this->assertEquals($user->getPassword(), 'hashed_password_super_safe');
    }

    public function testEmailAlreadyExist(): void
    {
        $this->service->register(new RegisterUserRequest('john.doe@gmail.com', 'superPwd'));
        $users = $this->userRepository->findAll();
        $this->assertCount(1, $users);

        $this->expectException(InvalidCredentialsException::class);
        $this->service->register(new RegisterUserRequest('john.doe@gmail.com', 'anotherGoodPwd'));
    }
    public function testEmailMalformed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"john.doe_gmail.com" is not a valid email address');
        $this->service->register(new RegisterUserRequest('john.doe_gmail.com', 'superPwd'));
    }

    public function testPwdLength(): void
    {
        $this->expectException(PasswordTooShortException::class);
        $this->expectExceptionMessage('This value is too short. It should have 6 characters or more.');
        $this->service->register(new RegisterUserRequest('john.doe@gmail.com', '123'));
    }
}
