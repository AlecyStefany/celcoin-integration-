<?php

namespace App\Data\CreateBoleto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CelcoinCreateBoletoReceiverRequest extends Data
{
    public function __construct(
        #[StringType(), Max(255)]
        public string $account,

        #[StringType(), Max(14)]
        public string $document,
    ) {}
}
