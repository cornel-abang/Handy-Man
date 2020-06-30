<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['invoice_id', 'payer_name', 'amount_paid', 'reference' ,'channel', 'card_type', 'payer_bank'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

}
