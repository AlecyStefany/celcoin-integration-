<?php

namespace App\Interfaces;


interface BoletoClientInterface
{
    public function createBoleto(): ?CreateBoletoResponseInterface;
}