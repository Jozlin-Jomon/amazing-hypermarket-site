<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'cat_code',
        'name',
        'description',
        'parent_id',
        'image_url',
        'status',
        'display_order',
    ];

    protected $casts = [
        'status' => 'integer',
        'display_order' => 'integer',
        'parent_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
