<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Apartment;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message'];

    public function apartments(): HasMany{
        return $this->hasMany(Apartment::class);
    }
}
