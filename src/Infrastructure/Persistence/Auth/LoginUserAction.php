<?php 

use App\Domain\User\Data\DTOs\Request\LoginUserRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginUserAction
{
    public function __construct(
        private LoginUserService $service
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array) $request->getParsedBody();

        $loginRequest = LoginUserRequest::fromArray($data);

        $success = $this->service->execute(request: $loginRequest);

        if (!$success) {
            $response->getBody()->write(json_encode([
                'error' => 'Credenciais inválidas'
            ]));
            return $response->withStatus(401);
        }

        $response->getBody()->write(json_encode([
            'message' => 'Login realizado com sucesso'
        ]));

        return $response->withStatus(200);
    }
}
