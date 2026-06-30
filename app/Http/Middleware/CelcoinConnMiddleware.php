<?php

namespace App\Http\Middleware;

use App\Services\CelcoinConection;
use Psr\Http\Message\RequestInterface;

class CelcoinConnMiddleware
{
    public static function handle(RequestInterface $request): RequestInterface
    {
        $host = parse_url(config('api.celcoin_url'), PHP_URL_HOST);
        $uri = $request->getUri()->withHost($host)->withScheme('https');

        return $request->withUri($uri);
    }

    public static function handleAuth(RequestInterface $request): RequestInterface
    {
        $request = self::handle($request);

        $service = app(CelcoinConection::class);
        $token = $service->createToken();

        return $request->withHeader('Authorization', "Bearer $token");
    }
}