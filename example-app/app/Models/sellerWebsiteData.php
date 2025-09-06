<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sellerWebsiteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'website_name',
        'da_score',
        'publishing_time',
        'example_website_name',
        'category',
        'normal_guest_price',
        'normal_link_price',
        'fc_guest_price',
        'fc_link_price',
    ];

    

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = is_array($value) ? implode(',', $value) : $value;
    }
}
