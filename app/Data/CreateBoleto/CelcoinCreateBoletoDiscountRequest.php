<?php

namespace App\Data\CreateBoleto;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CelcoinCreateBoletoDiscountRequest extends Data
{
    public function __construct(
        #[Numeric()]
        public float $amount,

        #[StringType(), In(['fixed', 'percentage'])]
        public string $modality,

        #[Nullable(), StringType()]
        public ?string $limitDate = null,
    ) {}
}
