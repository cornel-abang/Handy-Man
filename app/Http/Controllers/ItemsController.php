<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
	public static function storeItems($items, $invoice_id)
    {
        //Loop through the three arrays and create one super array for all ($allItems)
        $allItems = [];
        //create array to store the total price for each item to be returned back
        $totals = [];

        foreach ($items['item_name'] as $key => $value) {
            $total = $items['item_price'][$key] * $items['item_qty'][$key];
            array_push($allItems, [
                'invoice_id' => $invoice_id,
                'item_name' => $value,
                'item_price' => $items['item_price'][$key],
                'quantity' => $items['item_qty'][$key],
                'total' => $total
            ]);

            array_push($totals, [
            	'total'=> $total
            ]);
        }

        for($i = 0; $i < sizeof($allItems); $i++){
        	Item::create($allItems[$i]);
        }

        return $totals;
    }

    public static function getItems($inv_id)
    {
        return Item::where('invoice_id', $inv_id)
        						   ->latest()
                                   ->get();
    }
}
