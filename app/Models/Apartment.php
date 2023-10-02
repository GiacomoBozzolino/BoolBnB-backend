<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; 

use App\Models\User;
use App\Models\Service;
use App\Models\Lead;
use App\Models\Visitor;


class Apartment extends Model
{
    use HasFactory;

    // CONNESSIONE A USER
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // CONNESSIONE A SERVIZI
    public function services() {
        return $this->belongsToMany(Service::class);
    }
    // CONNESSIONE A LEADS(MESSAGGI)
    public function leads(){
        return $this->hasMany(Lead::class);
    }

    //CONNESSIONE A VISITOR
    public function visitors(){
        return $this->hasMany(Visitor::class);
    }
    // CONNESSIONE A SPONSOR
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'apartment_sponsors')->withPivot('end_at');
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
