<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'latitude',
        'longitude',
        'type',
        'address',
    ];

    public function images()
    {
        return $this->hasMany(PropertieImage::class);
    }

    public function visit()
{
    return $this->hasOne(Visit::class, 'propertie_id');
}
}
