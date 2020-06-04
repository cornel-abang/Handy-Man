<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public $timestamps = false;


    /*
        public function job_count(){
            return $this->hasMany(Job::class)->whereStatus(1)->count();
        }*/
}
