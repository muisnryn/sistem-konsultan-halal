<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING    = 'pending';
    case PAID       = 'paid';
    case SUCCESS    = 'success';   
    case SETTLEMENT = 'settlement';
    case FAILED     = 'failed';
    case EXPIRED    = 'expired';
    case CANCELLED  = 'cancelled';

    /**
     * Helper method untuk mengecek apakah pembayaran sudah lunas
     */
    public function isPaid(): bool
    {
        return in_array($this, [self::PAID, self::SUCCESS, self::SETTLEMENT]);
    }
}
