<?php 
namespace App\Domain\Company\Data\DTOs\Request;


final class RegisterCompanyRequest{

    public function __construct(
        private string $nomeEmpresa,
        private string $cnpj,
        private string $endereco,
        private string $telefone,
        private string $email
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nomeEmpresa: $data['nomeEmpresa'] ?? '',
            cnpj: $data['cnpj'] ?? '',
            endereco: $data['endereco'] ?? '',
            telefone: $data['telefone'] ?? '',
            email: $data['email'] ?? ''
        );
    }

    public function nomeEmpresa(): string
    {
        return $this->nomeEmpresa;
    }

    public function cnpj(): string
    {
        return $this->cnpj;
    }

    public function endereco(): string
    {
        return $this->endereco;
    }

    public function telefone(): string
    {
        return $this->telefone;
    }

    public function email(): string
    {
        return $this->email;
    }

}