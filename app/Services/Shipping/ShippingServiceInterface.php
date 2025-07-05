<?php

namespace App\Services\Shipping;

interface ShippingServiceInterface
{
    public function createShipment(array $data): array;
    public function calculateFees(array $data): float;
    public function trackShipment(string $trackingNumber): array;
    public function getOrderLabel(string $trackingNumber): array;
}
