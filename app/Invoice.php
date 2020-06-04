<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['service_id','sum_total'];

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function items()
    {
    	return $this->hasMany(Item::class);
    }
}
