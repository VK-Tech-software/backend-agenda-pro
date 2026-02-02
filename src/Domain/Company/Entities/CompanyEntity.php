<?php 
namespace App\Domain\Company\Entities;

use Dom\Entity;
use function DI\string;

final class CompanyEntity extends Entity {
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $cnpjcpf,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $city,
        public readonly string $state,
    ) {
        $this->changeName(name: $this->name);
    }

    public function changeName(string $name) {
        if ($name === "") {

        }
    }    

    public function changeEmail(string $email) {
        if ($email === "") {}
    }

    public function restore(
        string $id,
        string $name,
        string $cnpjcpf,
        string $email,
        string $phone,
        string $address,
        string $city,
        string $state
    ): self {
        return new self(
            id: $id,
            name: $name,
            cnpjcpf: $cnpjcpf,
            email: $email,
            phone: $phone,
            address: $address,
            city: $city,
        );  
    }

    public function create(
        string $name,
        string $cnpjcpf,
        string $email,
        string $phone,
        string $address,
        string $city,
        string $state
    ): self {
        return new self (
            id: null,
            name: $name,  
            cnpjcpf: $cnpjcpf,
            email: $email,
            phone: $phone,
            address: $address,
            city: $city,
            state: $state
        );
    }

    public function id(): ?int { return $this->id; }
    public function name(): string { return $this->name; }
    public function cvv(): string { return $this->cnpjcpf; }
    public function email(): string { return $this->email; }
    public function phone(): string { return $this->phone; }
    public function address(): string { return $this->address; }
    public function state(): string { return $this->state; }
    public function city(): string { return $this->city; }    

}