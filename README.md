# Celcoin Integration

Integração com a API da Celcoin (BaaS) para criação de boletos via Pix/Charge, construída com Laravel 13.

## Requisitos

- PHP 8.3+
- Composer
- Extensões PHP: `pdo_mysql`, `openssl`, `mbstring`
- Credenciais de acesso à Celcoin (sandbox ou produção)

## Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate
```

## Configuração

Preencha as variáveis no `.env`:

```env
URL_CELCOIN_SANDBOX=https://sandbox.openfinance.celcoin.dev/
CLIENT_ID_CELCOIN=seu_client_id
CLIENT_SECRET_CELCOIN=seu_client_secret
GRAND_TYPE_CELCOIN=client_credentials

CACHE_STORE=file
```

## Rodando

```bash
php artisan serve
```

## Documentação (Swagger)

Após subir o servidor, acesse:

```
http://127.0.0.1:8000/api/documentation
```

Para regenerar a documentação após alterar anotações:

```bash
php artisan l5-swagger:generate
```

## Testes

```bash
php artisan test
```

## Endpoints

### POST /api/boletos

Cria um boleto na Celcoin.

**Body:**

```json
{
  "externalId": "TesteSandbox_123",
  "merchantCatagoryCode": "0000",
  "expirationAfterPayment": 1,
  "dueDate": "2026-12-31",
  "amount": 10.00,
  "key": "teste@chavepix.com.br",
  "debtor": {
    "name": "Erick Augusto Farias",
    "document": "42318970858",
    "postalCode": "06474320",
    "city": "Barueri",
    "publicArea": "Alameda Holanda",
    "number": "123",
    "neighborhood": "Alphaville Residencial Um",
    "state": "SP"
  },
  "receiver": {
    "account": "300543550143",
    "document": "46532252573"
  },
  "instructions": {
    "fine": 10,
    "interest": 5,
    "discount": {
      "amount": 1,
      "modality": "fixed",
      "limitDate": "2026-12-20T00:00:00.0000000"
    }
  }
}
```

**Respostas:**

| Código | Descrição |
|--------|-----------|
| 201 | Boleto criado com sucesso |
| 422 | Dados inválidos |
| 500 | Erro ao criar boleto |
| 504 | Timeout na comunicação com a Celcoin |

## Estrutura

```
app/
├── Data/CreateBoleto/          # DTOs com validação (spatie/laravel-data)
│   ├── CelcoinCreateBoletoRequest.php
│   ├── CelcoinCreateBoletoDebtorRequest.php
│   ├── CelcoinCreateBoletoReceiverRequest.php
│   ├── CelcoinCreateBoletoInstructionsRequest.php
│   ├── CelcoinCreateBoletoDiscountRequest.php
│   ├── CelcoinCreateBoletoResponse.php
│   └── CelcoinCreateBoletoTimeoutResponse.php
├── Http/
│   ├── Controllers/BoletoController.php
│   └── Middleware/CelcoinConnMiddleware.php  # Seta host e token no request
├── Services/
│   ├── CelcoinConection.php    # Geração de token OAuth
│   └── CreateBoletoService.php # Chamada à API de criação de boleto
└── Interfaces/
    ├── BoletoClientInterface.php
    └── CreateBoletoResponseInterface.php
```

## Fluxo de autenticação

A autenticação é feita via OAuth2 com `grant_type=client_credentials`. O token é gerado automaticamente pelo `CelcoinConnMiddleware` antes de cada chamada autenticada à API.
