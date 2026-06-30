<?php

namespace App\Data\CreateBoleto;

use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Data;

class CelcoinCreateBoletoInstructionsRequest extends Data
{
    public function __construct(
        #[Numeric(), Min(0)]
        public float $fine = 0,

        #[Numeric(), Min(0)]
        public float $interest = 0,

        #[Nullable()]
        public ?CelcoinCreateBoletoDiscountRequest $discount = null,
    ) {}

    public function isEmpty(): bool
    {
        return $this->fine === 0.0
            && $this->interest === 0.0
            && is_null($this->discount);
    }
}
