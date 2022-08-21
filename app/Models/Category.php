<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'is_active'
    ];

    public function parent() {
        return $this->hasOne(Category::class,'id','parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class,'parent_id','id');
    }

}
