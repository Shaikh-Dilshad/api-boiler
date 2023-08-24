<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketdetail extends Model
{
    protected $fillable = [
        'id',
        'ticket_id',
        'user_id',
        'description'
    ];
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
