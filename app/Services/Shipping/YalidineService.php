<?php

// File: app/Services/Shipping/YalidineService.php
namespace App\Services\Shipping;

use PiteurStudio\CourierDZ\Models\ShippingProvider;

class YalidineService extends CourierDzBaseService
{
    public function __construct(array $settings)
    {
        $credentials = [
            'key'   => $settings['api_key'] ?? null,
            'token' => $settings['api_token'] ?? null,
        ];
        parent::__construct(ShippingProvider::YALIDINE, $credentials);
    }
}