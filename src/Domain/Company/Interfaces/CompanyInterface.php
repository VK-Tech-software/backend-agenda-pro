<?php 
namespace App\Domain\Company\Interfaces;

interface CompanyInterface {

    public function save(): bool;
    public function findById(int $id): int;
    public function updateDastivar(int $id, int $status): void;
    public function updateDados(): bool;

}