<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Apartment;

class Service extends Model
{
    use HasFactory;

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

    protected $fillable = [ 
        'type', 
        'icon'
    ];
}