<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Imported 

use App\Models\Apartment;


class Sponsor extends Model
{
    use HasFactory;

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'apartment_sponsors')->withPivot('end_at');
    }

    
    protected $fillable = [
        'title',
        'price',
        'duration',
        'description',
        'deadline'
    ];
}
