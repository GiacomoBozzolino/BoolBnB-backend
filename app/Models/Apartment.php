<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; 

use App\Models\User;
use App\Models\Service;

class Apartment extends Model
{
    use HasFactory;

    /*connessione con User*/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'n_rooms',
        'n_beds',
        'n_bathrooms',
        'square_meters',
        'address',
        'cover_img',
        'latitude',
        'longitude',
        'visibility',
        'description',
        'service_id',
    ];

    public static function generateSlug($title){
        return Str::slug($title, '-');
    }
}
