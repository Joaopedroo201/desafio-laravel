<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected AddressService $addressService) {}

    public function register(array $data): ?User
    {
        $address = $this->addressService->getAddressFromCep($data['cep']);
        if (!$address) return null;
        
        return User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'cep'          => $data['cep'],
            'number'       => $data['number'],
            'street'       => $address['street'],
            'neighborhood' => $address['neighborhood'],
            'city'         => $address['city'],
            'state'        => $address['state'],
            'role'         => 'user',
        ]);
    }
}
