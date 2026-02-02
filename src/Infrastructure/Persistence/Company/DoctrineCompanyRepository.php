<?php 

use App\Domain\Company\Entities\CompanyEntity;
use App\Domain\Company\Interfaces\CompanyInterface;
use App\Infrastructure\Persistence\Company\CompanyOrm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


class DoctrineCompanyRepository implements CompanyInterface {

    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(): bool {
        $this->em->persist($this);
        $this->em->flush();
        return true;
    }

    public function findById(int $id): int {
        return $this->em->find(CompanyOrm::class, $id);
    }

    public function updateDastivar(int $id, int $status): void {

    $this->em->update(CompanyOrm::class, $id, $status);

    }

    public function updateDados(): bool {

    }

}