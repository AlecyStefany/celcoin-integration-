<?php

namespace App\Data\CreateBoleto;

use App\Interfaces\CreateBoletoResponseInterface;
use Illuminate\Http\Client\Response;

class CelcoinCreateBoletoTimeoutResponse implements CreateBoletoResponseInterface
{
    public function getResponse(): Response
    {
        abort(504, 'Timeout ao criar boleto na Celcoin.');
    }

    public function getExternalBoletoId(): ?string
    {
        return null;
    }
}
