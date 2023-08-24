<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'is_deleted'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function value_lists()
    {
        return $this->hasMany(ValueList::class)->with('value')
            ->where('is_deleted', '=', FALSE);
        }
        
        public function active_value_lists()
        {
            return $this->hasMany(ValueList::class)
            ->where('is_deleted', '=', FALSE)
            ->where('is_active', '=', 1);
    }
}
