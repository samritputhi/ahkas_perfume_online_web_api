<?php

namespace App\Ahkas\Domain\SlideShow;

use Database\Factories\SlideShowFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @author SOPHEAK
 */
class SlideShowModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'slide_shows';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // public function setImageAttribute($value)
    // {
    //     if (Str::contains($value, 'https')) {
    //         $this->attributes['image'] = $value;
    //     } else {
    //         $this->attributes['image'] = Storage::disk()->url($value);
    //     }
    // }

    protected static function newFactory(): SlideShowFactory
    {
        return SlideShowFactory::new();
    }
}
