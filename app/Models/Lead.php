<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// import



use App\Models\Apartment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'content', 'apartment_id'];

    public function apartments(): BelongsTo{
        return $this->belongsTo(Apartment::class);
    }
}
