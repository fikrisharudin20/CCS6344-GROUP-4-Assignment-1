<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['user_id', 'event_id'];

    // Define the relationship to the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to the Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
