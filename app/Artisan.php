<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    protected $fillable = ['full_name',
						   'phone',
							'email',
							'address',
							'password',
							'state',
							'lga',
							'gender',
							'skill'];
	public function service()
	{
		return $this->hasOne(Service::class);
	}
}

