<?php
declare(strict_types=1);

namespace App\User\Domain\Model;

use App\Shared\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private array $roles = [];
    public Uuid $id;

    public function __construct(private Email $email, private string $password)
    {
        $this->id = Uuid::v4();
    }

    public function setId(Uuid $id): Uuid
    {
        $this->id = $id;
        return $this->id;
    }
    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $roles = ['ROLE_USER'];
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
}