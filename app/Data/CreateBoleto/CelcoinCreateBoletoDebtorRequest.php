<?php

namespace App\Data\CreateBoleto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CelcoinCreateBoletoDebtorRequest extends Data
{
    public function __construct(
        #[StringType(), Max(255)]
        public string $name,

        #[StringType(), Max(14)]
        public string $document,

        #[StringType(), Max(8)]
        public string $postalCode,

        #[StringType(), Max(255)]
        public string $city,

        #[StringType(), Max(255)]
        public string $publicArea,

        #[StringType(), Max(10)]
        public string $number,

        #[StringType(), Max(255)]
        public string $neighborhood,

        #[StringType(), Max(2)]
        public string $state,
    ) {}
}
