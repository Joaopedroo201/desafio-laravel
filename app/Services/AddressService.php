<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AddressService
{
    public function getAddressFromCep(string $cep): ?array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        if ($response->failed() || isset($response['erro'])) {
            return null;
        }
        return [
            'street'      => $response['logradouro'] ?? '',
            'neighborhood'=> $response['bairro'] ?? '',
            'city'        => $response['localidade'] ?? '',
            'state'       => $response['estado'] ?? '',
        ];
    }
}
