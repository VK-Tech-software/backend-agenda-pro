<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Company;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'companies')]
class CompanyOrm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cnpjcpf = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $tipoConta = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $telefone = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getCnpjCpf(): ?string { return $this->cnpjcpf; }
    public function getTipoConta(): ?string { return $this->tipoConta; }
    public function getTelefone(): ?string { return $this->telefone; }
}