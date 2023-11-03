<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertieImage extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function propertie()
    {
        return $this->belongsTo(Propertie::class);
    }
}
