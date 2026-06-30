<?php

namespace App\Data\CreateBoleto;

use App\Interfaces\CreateBoletoResponseInterface;
use Illuminate\Http\Client\Response;
use JsonSerializable;

class CelcoinCreateBoletoResponse implements CreateBoletoResponseInterface, JsonSerializable
{
    public function __construct(private readonly Response $response) {}

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getExternalBoletoId(): ?string
    {
        return $this->response->json('transactionId');
    }

    public function jsonSerialize(): mixed
    {
        return $this->response->json();
    }
}
