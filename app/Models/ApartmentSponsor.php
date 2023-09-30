<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentSponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id', 
        'sponsor_id',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime', 
        'end_at' => 'datetime', 
    ];

    public function sponsor(){
        return $this->belongsToOne(Apartment::class);
    }

    public function apartments(){
        return $this->belongsToMany(Apartment::class);
    }
}
