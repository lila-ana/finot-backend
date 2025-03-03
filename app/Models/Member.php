<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members'; 
    protected $primaryKey = 'member_id';

    // Set the incrementing property to false
    public $incrementing = false;

    // Specify the key type
    protected $keyType = 'string';

    // Fillable attributes
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'address',
        'phone_number',
        'email_address',
        'date_of_baptism',
        'membership_status',
        'previous_church_affiliation',
        'family_members',
        'children_info',
        'areas_of_interest',
        'spiritual_gifts',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'profile_picture',
        'notes_comments',
        'data_protection_consent',
        'media_release_consent',
        'profession_detail',
        'blood_type',
        'unique_identifier',  
        'elder_id',  
        'class_id',
    ];

    // Define the boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the member_id when creating a new member
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
            
            // Generate the unique identifier
            $year = date('Y');
            $prefix = "FT/AT/KM/M/";

            // Count existing members for the current year
            $currentYearCount = Member::withTrashed()
                ->whereYear('created_at', $year)
                ->count() + 1;

            // Format the unique identifier with zero padding
            $model->unique_identifier = $prefix . str_pad($currentYearCount, 3, '0', STR_PAD_LEFT) . '/' . $year;
        });
    }

    // Define relationships
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }

     public function elder()
    {
        return $this->belongsTo(Elder::class, 'elder_id', 'elder_id'); 
    }

    public function class()
    {
       return $this->belongsTo(ClassModel::class, 'class_id', 'class_id'); 
    }

    public function scopeAttendedToday($query)
    {
       return $query->whereDate('created_at', Carbon::today());
    }

}
