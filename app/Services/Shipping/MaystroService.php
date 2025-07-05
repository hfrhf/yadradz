<?php

// File: app/Services/Shipping/MaystroService.php
namespace App\Services\Shipping;

use PiteurStudio\CourierDZ\Models\ShippingProvider;

class MaystroService extends CourierDzBaseService
{
    public function __construct(array $settings)
    {
        // Mayestro Delivery only needs a token
        $credentials = [
            'token' => $settings['api_token'] ?? null,
        ];
        parent::__construct(ShippingProvider::MAYSTRO, $credentials);
    }
}