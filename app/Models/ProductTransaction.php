<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class ProductTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'city',
        'address',
        'booking_trx_id',
        'post_code',
        'quantity',
        'sub_total_amount',
        'grand_total_amount', 
        'discount_amount',
        'is_paid',
        'proof'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($productTransaction) {
            if (Auth::check()) {
                $productTransaction->user_id = Auth::id();
            } 
            $productTransaction->name = Auth::user()->name;
            $productTransaction->phone_number = Auth::user()->phone_number ?? null;

        });
    }

    public static function generateUniqueBookingTrxId(): string
    {
        $prefix = 'NNSA';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function promoCode(): belongsTo
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
}
