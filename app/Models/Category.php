<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories'; 
    protected $primaryKey = 'categories_id'; // Match the primary key

    protected $fillable = [
        'name',
        'description',
    ];

    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Specify that the key type is a string

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->categories_id = (string) Str::uuid(); // Generate UUID when creating
        });
    }

    public function churchGoods()
    {
        return $this->hasMany(ChurchGood::class, 'categories_id'); // Correct foreign key
    }
}


