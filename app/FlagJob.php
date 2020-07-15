<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlagJob extends Model
{
    protected $guarded = [];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function messages()
    {
    	return $this->hasMany(Message::class);
    }
}
