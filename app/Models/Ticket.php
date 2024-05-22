<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;
use App\Models\Payment;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'userID',
        'eventID',
        'paymentID',
    ];

    // Many to 1 relationship with User
    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }  

    // Many to 1 relationship with Event
    public function event() {
        return $this->belongsTo(Event::class, 'eventID');
    }

    // Many to 1 relationship with Payment
    public function payment() {
        return $this->belongsTo(Payment::class, 'paymentID');
    }  


}
