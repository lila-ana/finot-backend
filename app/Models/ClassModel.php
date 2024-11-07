<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'class_id';

    protected $table = 'classes'; 

    // Set the incrementing property to false
    public $incrementing = false;

    // Specify the key type
    protected $keyType = 'string';

    // Define the UUID generation in the boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    
    protected $fillable = [
        'class_name',
        'description',
        'max_capacity',
        'class_type',
        'schedule',
        'location',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

     public function members()
    {
        return $this->hasMany(Member::class, 'class_id', 'class_id');
    }
}
