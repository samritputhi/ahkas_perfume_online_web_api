<?php

namespace App\Ahkas\Domain\Promotion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @author SOPHEAK
 */
class PromotionRuleModel extends Model
{

    public $timestamps = false;

    protected $table = 'promotion_rules';

    protected $guarded = [];

    protected $hidden = [];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(PromotionModel::class);
    }
}
