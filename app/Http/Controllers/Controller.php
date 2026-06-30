<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(title: 'Celcoin Integration API', version: '1.0.0', description: 'API de integração com a Celcoin')]
#[OA\Server(url: '/api', description: 'Servidor local')]
abstract class Controller {}
