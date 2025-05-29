<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = 'offer_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'offer_code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status',
        'offer_scope',
    ];
    protected $casts = [
        'status' => 'integer',
    ];
}
