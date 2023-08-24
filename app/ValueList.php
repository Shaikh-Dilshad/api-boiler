<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValueList extends Model
{
    protected $fillable = [
        'value_id',
        'company_id',
        'description',
        'code',
        'is_active',
        'is_deleted'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function value()
    {
        return $this->belongsTo(Value::class);
    }
}
