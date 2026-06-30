<?php

namespace Tests\Feature;

use App\Services\CelcoinConection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CelcoinBoletoTest extends TestCase
{

    public function test_cria_token_com_sucesso(): void
    {
        Http::fake([
            '*/v5/token' => Http::response(['access_token' => 'fake-token-abc'], 200),
        ]);

        $service = new CelcoinConection();
        $token = $service->createToken();

        $this->assertSame('fake-token-abc', $token);
    }

    public function test_cria_token_retorna_null_em_erro_servidor(): void
    {
        Http::fake([
            '*/v5/token' => Http::response([], 500),
        ]);

        $token = (new CelcoinConection())->createToken();

        $this->assertNull($token);
    }

    public function test_cria_boleto_via_endpoint(): void
    {
        Http::fake([
            '*/v5/token'      => Http::response(['access_token' => 'fake-token-abc'], 200),
            '*/baas/v2/charge' => Http::response([
                'transactionId' => 'txn-001',
                'status'        => 'CREATED',
            ], 200),
        ]);

        $response = $this->postJson('/api/boletos', [
            'externalId'             => 'TesteSandbox_123',
            'merchantCatagoryCode'   => '0000',
            'expirationAfterPayment' => 1,
            'dueDate'                => '2026-12-31',
            'amount'                 => 10.00,
            'key'                    => 'teste@chavepix.com.br',
            'debtor' => [
                'name'         => 'Erick Augusto Farias',
                'document'     => '42318970858',
                'postalCode'   => '06474320',
                'city'         => 'Barueri',
                'publicArea'   => 'Alameda Holanda',
                'number'       => '123',
                'neighborhood' => 'Alphaville Residencial Um',
                'state'        => 'SP',
            ],
            'receiver' => [
                'account'  => '300543550143',
                'document' => '46532252573',
            ],
        ]);

        $response->assertStatus(201);
    }

}
