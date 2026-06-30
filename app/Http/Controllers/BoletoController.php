<?php

namespace App\Http\Controllers;

use App\Data\CreateBoleto\CelcoinCreateBoletoRequest;
use App\Services\CreateBoletoService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class BoletoController extends Controller
{
    public function __construct(private readonly CreateBoletoService $service) {}

    #[OA\Post(
        path: '/boletos',
        summary: 'Criar boleto na Celcoin',
        tags: ['Boletos'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['externalId', 'merchantCatagoryCode', 'expirationAfterPayment', 'dueDate', 'amount', 'key', 'debtor', 'receiver'],
                properties: [
                    new OA\Property(property: 'externalId', type: 'string', example: 'TesteSandbox_123'),
                    new OA\Property(property: 'merchantCatagoryCode', type: 'string', example: '0000'),
                    new OA\Property(property: 'expirationAfterPayment', type: 'integer', example: 1),
                    new OA\Property(property: 'dueDate', type: 'string', format: 'date', example: '2026-12-31'),
                    new OA\Property(property: 'amount', type: 'number', format: 'float', example: 10.00),
                    new OA\Property(property: 'key', type: 'string', example: 'teste@chavepix.com.br'),
                    new OA\Property(
                        property: 'debtor',
                        type: 'object',
                        required: ['name', 'document', 'postalCode', 'city', 'publicArea', 'number', 'neighborhood', 'state'],
                        properties: [
                            new OA\Property(property: 'name', type: 'string', example: 'Erick Augusto Farias'),
                            new OA\Property(property: 'document', type: 'string', example: '42318970858'),
                            new OA\Property(property: 'postalCode', type: 'string', example: '06474320'),
                            new OA\Property(property: 'city', type: 'string', example: 'Barueri'),
                            new OA\Property(property: 'publicArea', type: 'string', example: 'Alameda Holanda'),
                            new OA\Property(property: 'number', type: 'string', example: '123'),
                            new OA\Property(property: 'neighborhood', type: 'string', example: 'Alphaville Residencial Um'),
                            new OA\Property(property: 'state', type: 'string', example: 'SP'),
                        ]
                    ),
                    new OA\Property(
                        property: 'receiver',
                        type: 'object',
                        required: ['account', 'document'],
                        properties: [
                            new OA\Property(property: 'account', type: 'string', example: '300543550143'),
                            new OA\Property(property: 'document', type: 'string', example: '46532252573'),
                        ]
                    ),
                    new OA\Property(
                        property: 'instructions',
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'fine', type: 'number', example: 10.0),
                            new OA\Property(property: 'interest', type: 'number', example: 5.0),
                            new OA\Property(
                                property: 'discount',
                                type: 'object',
                                nullable: true,
                                properties: [
                                    new OA\Property(property: 'amount', type: 'number', example: 1.0),
                                    new OA\Property(property: 'modality', type: 'string', example: 'fixed'),
                                    new OA\Property(property: 'limitDate', type: 'string', example: '2026-12-20T00:00:00.0000000'),
                                ]
                            ),
                        ]
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Boleto criado com sucesso',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'transactionId', type: 'string', example: 'txn-001'),
                        new OA\Property(property: 'status', type: 'string', example: 'CREATED'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Dados inválidos'),
            new OA\Response(response: 500, description: 'Erro ao criar boleto'),
        ]
    )]
    public function store(CelcoinCreateBoletoRequest $request): JsonResponse
    {
        $response = $this->service->createBoletoOnBank($request);

        if ($response === null) {
            return response()->json(['message' => 'Erro ao criar boleto.'], 500);
        }

        return response()->json($response, 201);
    }
}
