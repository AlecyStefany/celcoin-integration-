<?php

namespace App\Interfaces;

use Illuminate\Http\Client\Response;

interface CreateBoletoResponseInterface
{
    public function getResponse(): Response;

    public function getExternalBoletoId(): ?string;
}
