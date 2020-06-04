<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
    						'invoice_id',
    						'item_name',
    						'item_price',
    						'quantity',
    						'total'
    					];

}

