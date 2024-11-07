<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'attendance_id';
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
    protected $fillable = ['attendance_id', 'elder_id', 'class_id', 'member_id', 'attended'];

    public function elder()
    {
        return $this->belongsTo(Elder::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class); // Assuming you have a ClassModel
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
