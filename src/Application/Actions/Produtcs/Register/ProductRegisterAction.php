<?php 
namespace App\Application\Actions\Produtcs\Register;

use App\Application\Actions\Action;
use App\Domain\Products\Services\ProductService;    

class ProductRegisterAction extends Action {
    public function __construct(private readonly ProductService $services) {}

    public function action(): \Psr\Http\Message\ResponseInterface {
        return $this->respondWithData(['message' => 'Product registered successfully']);
    }
}