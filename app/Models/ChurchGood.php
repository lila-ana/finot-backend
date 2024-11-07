<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChurchGood extends Model
{
    use HasFactory;

    protected $table = 'church_goods'; 
    protected $primaryKey = 'church_goods_id';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'categories_id',
    ];

    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Specify that the key type is a string

   protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->church_goods_id = (string) Str::uuid(); // Generate UUID when creating
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id'); // Foreign key
    }

}
