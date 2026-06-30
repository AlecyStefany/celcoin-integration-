<?php

namespace App\Data\CreateBoleto;

use DateTime;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class CelcoinCreateBoletoRequest extends Data
{
    public function __construct(
        #[StringType()]
        public string $externalId,

        #[StringType()]
        public string $merchantCatagoryCode,

        #[IntegerType(), Min(1)]
        public int $expirationAfterPayment,

        #[Date(), WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public DateTime $dueDate,

        #[Numeric()]
        public float $amount,

        #[StringType()]
        public string $key,

        public CelcoinCreateBoletoDebtorRequest $debtor,

        public CelcoinCreateBoletoReceiverRequest $receiver,

        #[Nullable()]
        public ?CelcoinCreateBoletoInstructionsRequest $instructions = null,

        #[Nullable()]
        public ?array $split = null,
    ) {}

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['dueDate'] = $this->dueDate->format('Y-m-d');

        if (is_null($this->split)) {
            unset($data['split']);
        }

        if ($this->instructions !== null) {
            if ($this->instructions->fine == 0) {
                unset($data['instructions']['fine']);
            }

            if ($this->instructions->interest == 0) {
                unset($data['instructions']['interest']);
            }

            if (is_null($this->instructions->discount)) {
                unset($data['instructions']['discount']);
            }

            if ($this->instructions->isEmpty()) {
                unset($data['instructions']);
            }
        }

        $data['debtor']['postalCode'] = (string) $data['debtor']['postalCode'];

        return $data;
    }
}
