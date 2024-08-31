<?php

namespace App\Ahkas\Domain\Promotion;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @author SOPHEAK
 */
class PromotionModel extends Model
{

    protected $table = 'promotions';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(PromotionRuleModel::class, 'promotion_id', 'id');
    }

    public function isActive(): bool
    {
        return  $this->active
            && $this->issued_at < Carbon::now()
            && $this->expired_at > Carbon::now();
    }
}
