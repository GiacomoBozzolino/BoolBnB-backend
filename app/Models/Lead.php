<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Apartment;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'content', 'apartment_id'];

    public function apartments(): BelongsTo{
        return $this->belongsTo(Apartment::class);
    }

    public function index()
    {
        $user = Lead::first();
        $newDate = $user->created_at->format('d-m-Y');
        
        // dd($newDate);
    }
}
