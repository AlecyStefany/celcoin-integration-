<?php

namespace App\Services;

use App\Data\CreateBoleto\CelcoinCreateBoletoRequest;
use App\Data\CreateBoleto\CelcoinCreateBoletoResponse;
use App\Data\CreateBoleto\CelcoinCreateBoletoTimeoutResponse;
use App\Http\Middleware\CelcoinConnMiddleware;
use App\Interfaces\CreateBoletoResponseInterface;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\RequestInterface;

class CreateBoletoService
{
    public function createBoletoOnBank(
        CelcoinCreateBoletoRequest $data,
    ): ?CreateBoletoResponseInterface {
        $route = 'baas/v2/charge';
        $body = $data->toArray();

        try {
            $response = Http::withRequestMiddleware(
                fn (RequestInterface $requestInterface) => CelcoinConnMiddleware::handleAuth($requestInterface)
            )
                ->timeout(60)
                ->post($route, $body);
        } catch (HttpClientException $ex) {
            Log::critical('CELCOIN_CREATE_BOLETO_HTTP_ERROR', [
                'route' => $route,
                'payload' => $body,
                'error' => $ex->getMessage(),
            ]);

            return new CelcoinCreateBoletoTimeoutResponse();
        }

        return new CelcoinCreateBoletoResponse($response);
    }
}
