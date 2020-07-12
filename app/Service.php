<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
            'user_id',
            'state',
            'category',
            'local_govt',
            'street_addr',
            'description',
            'visiting_date',
            'visiting_time'
        ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }
}
