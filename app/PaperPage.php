<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaperPage extends Model
{
    protected $fillable = [
        'id',
        'paper_id',
        'user_id',
        'title'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function paper(){
        return $this->belongsTo(Paper::class);
    }
}
