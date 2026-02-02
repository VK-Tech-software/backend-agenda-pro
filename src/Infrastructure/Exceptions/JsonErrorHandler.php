<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class JsonErrorHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke($request, $exception, $displayErrorDetails, $logErrors, $logErrorDetails): Response
    {
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse();

        if ($exception instanceof CustomException) {
            $payload = [
                'error' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ];
            $status = $exception->getStatusCode();
        } else {
            $payload = [
                'error' => 'Internal Server Error',
            ];
            $status = 500;
        }

        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
