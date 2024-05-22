<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cart;
use App\Models\Ticket;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'startTime',
        'endTime',
        'address',
        'description',
        'price',
        'lat',
        'long',
        'userID',
    ];

    // Many to 1 relationship with user
    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }  

    // 1 to Many relationship with cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

     // 1 to Many relationship with tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
