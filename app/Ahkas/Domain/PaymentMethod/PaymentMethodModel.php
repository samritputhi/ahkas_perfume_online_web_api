<?php

namespace App\Ahkas\Domain\PaymentMethod;

use Database\Factories\PaymentMethodFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * @author SOPHEAK
 */
class PaymentMethodModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_methods';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function newFactory(): PaymentMethodFactory
    {
        return PaymentMethodFactory::new();
    }
}
