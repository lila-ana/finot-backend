<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Events extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events'; 
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            });
        }
    protected $fillable = [
        'id',
        'event_name',
        'event_date',
        'event_time',
        'location',
        'description',
        'event_type',
        'capacity',
        'organizer_name',
        'contact_info',
        'status', 
    ];
        
}
