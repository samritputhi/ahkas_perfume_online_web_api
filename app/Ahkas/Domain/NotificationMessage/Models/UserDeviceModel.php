<?php

namespace App\Ahkas\Domain\NotificationMessage\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceModel extends Model
{

    protected $primaryKey = null;

    public $incrementing = false;

    protected $table = 'user_devices';

    protected $guarded = [];

    public function scopeToken(): array
    {
        return $this->pluck('token')->toArray();
    }
}
