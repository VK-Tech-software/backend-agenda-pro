<?php 
namespace App\Application\Actions\Clients\Register; 

use App\Application\Actions\Action;
use App\Domain\Clients\Data\DTOs\Request\ClientRequest;
use App\Domain\Clients\Services\ClientService;
use App\Domain\Company\Repositories\CompanyRepository;
use Psr\Http\Message\ResponseInterface;


final class ClientRegisterAction extends Action {

    public function __construct(
        private ClientService $clientService,
        private CompanyRepository $companyRepository,
    ) {

    }

        protected function action(): ResponseInterface
        {
            $data = $this->request->getParsedBody();

            $userId = (int) ($this->request->getAttribute('userId') ?? 0);
            $companyId = $this->companyRepository->findByUserId($userId);
            if (!$companyId) {
                return $this->respondWithData(['message' => 'Empresa não encontrada'], 404);
            }

            $request = ClientRequest::fromArray(data: $data);
    
            $clientId = $this->clientService->registerForCompany(client: $request, companyId: (int) $companyId);
    
            return $this->respondWithData(['id' => $clientId]);
        }

}