<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Elder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'elder_id';

    protected $table = 'elders'; 

    // Set the incrementing property to false
    public $incrementing = false;

    // Specify the key type
    protected $keyType = 'string';

    // Fillable attributes
    protected $fillable = [
        'name',
        'contact_info',
        'email',
        'phone',
        'address',
        'position',
        'bio',
        'unique_identifier'
    ];

    // Define the boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the elder_id when creating a new elder
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
            
            // Generate the unique identifier
            $year = date('Y');
            $prefix = "FT/AT/KM/EL/";

            // Count existing elders for the current year
            $currentYearCount = Elder::whereYear('created_at', $year)->count() + 1;

            // Format the unique identifier with zero padding
            $model->unique_identifier = $prefix . str_pad($currentYearCount, 3, '0', STR_PAD_LEFT) . '/' . $year;
        });
    }

    // Define the relationship with Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

     public function members()
    {
        return $this->hasMany(Member::class, 'elder_id', 'elder_id');
    }

}
