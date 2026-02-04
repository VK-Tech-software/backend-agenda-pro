<?php
namespace App\Application\Actions\Companys\Register;

use App\Application\Actions\Action;
use App\Domain\Company\Data\DTOs\Request\RegisterCompanyRequest;
use App\Domain\Company\Services\CompanyService;

class CompanyRegisterAction extends Action
{

 public function __construct(private CompanyService $companyService)
    {
        $this->companyService = $companyService;

    }

    public function action(): \Psr\Http\Message\ResponseInterface
    {
        $body = (array)$this->request->getParsedBody();

        $request = RegisterCompanyRequest::fromArray($body);

        $data = $this->companyService->register($request);

        return $this->respondWithData($data);

    }
}