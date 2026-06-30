<?php

namespace App\Services;

use App\Http\Middleware\CelcoinConnMiddleware;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;

class CelcoinConection
{  public function __construct() {}

    public function createToken(): ?string
    {
        $response = Http::asForm()->withRequestMiddleware(
            fn (RequestInterface $requestInterface) => CelcoinConnMiddleware::handle($requestInterface)
        )
            ->post('v5/token', [
                'client_id' => config('api.client_id'),
                'grant_type' => config('api.grant_type'),
                'client_secret' => config('api.client_secret'),
            ]);

        if ($response->serverError()) {
            return null;
        }

        if ($response->clientError()) {
            return null;
        }

        return $response['access_token'];

    }
}