<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'car_photos';

    protected $fillable = [
        'car_id',
        'filename',
        'path',
        'original_name'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
