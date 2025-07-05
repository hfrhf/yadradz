<?php

namespace App\Models;

use App\Models\CustomerOrders;
use App\Models\ConfirmerPayment;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword; // إضافة الاستيراد الخاص بـ CustomResetPassword



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'views',
        // --- ✨ بداية الإضافة الجديدة ✨ ---
        'confirmer_payment_type',
        'confirmer_payment_rate',
        'confirmer_cancellation_rate',
        'salary_payout_day', // <-- ✨ إضافة جديدة
        // --- 🔚 نهاية الإضافة الجديدة 🔚 ---
    ];



    public function getRedirectRoute()
    {
        return 'admin_dashboard';

    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Override the default email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Override the default password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function handledOrders(): HasMany
{
    return $this->hasMany(CustomerOrders::class, 'confirmer_id');
}

/**
 * Get the payments made to this confirmer.
 */
public function payments(): HasMany
{
    return $this->hasMany(ConfirmerPayment::class, 'user_id');
}
}
