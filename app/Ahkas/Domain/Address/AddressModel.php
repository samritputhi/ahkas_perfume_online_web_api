<?php

namespace App\Ahkas\Domain\Address;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author SOPHEAK
 */
class AddressModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery_addresses';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
