<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ticket extends Model
{
    protected $fillable = [
        'id',
        'company_id',
        'user_id',
        'title',
        'type',
        'category',
        'status'
    ];
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticketdetails(){
        return $this->hasMany(Ticketdetail::class);
    }
    
}
