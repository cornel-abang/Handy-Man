<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
    					'flag_job_id',
    					'message',
    					'message_type'
    					];
    public function flag_job()
    {
    	return $this->belongsTo(FlagJob::class);
    }
}
