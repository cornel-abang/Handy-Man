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

    public static function storeItemsUpdate($items, $invoice_id)
    {
        //Loop through the three arrays and create one super array for all ($allItems)
        $all_items = [];
        //create array to store the total price for each item to be returned back
        $totals = [];

        //create an array of al the old items
        //recognized as the ones without newin their name
        //and thier updates
        foreach ($items['item_name'] as $key => $value) {
            $total = $items['item_price'][$key] * $items['item_qty'][$key];
            array_push($all_items, [
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

        //first get the items that match the privded invoice id
        $items_in_db = Item::where('invoice_id',$invoice_id)->get();
    
       //loop thrugh them while updating them 
        for($i = 0; $i < sizeof($all_items); $i++){
            //update them with the new provided from th user
            $items_in_db[$i]->update($all_items[$i]);
        }

        //checkif any new items were added by using the new_items naming
        //and add them to the db by creating new items
        if (array_key_exists('item_name_new', $items)) {

            $totals = self::createNewItems($items, $invoice_id, $totals);
        }

        return $totals;
    }


    public static function createNewItems(array $items, $invoice_id, array $totals)
    {
        //create new array to hold all new items
        $all_new_items = [];

            //loop through and ad all new items to the created array
            //while also pushing items into the total array to be returned
            foreach ($items['item_name_new'] as $key => $value) {

                $total = $items['item_price_new'][$key] * $items['item_qty_new'][$key];

                array_push($all_new_items, [
                    'invoice_id' => $invoice_id,
                    'item_name' => $value,
                    'item_price' => $items['item_price_new'][$key],
                    'quantity' => $items['item_qty_new'][$key],
                    'total' => $total
                ]);

                array_push($totals, [
                    'total'=> $total
                ]);
            }
            //loop through and create the new items
            for($i = 0; $i < sizeof($all_new_items); $i++)
            {
                Item::create($all_new_items[$i]);
            }

        return $totals;
    }

    /*
    NO LONGER IN USE FOR NOW
     
    public static function getItems($inv_id)
    {
        return Item::where('invoice_id', $inv_id)
        						   ->latest()
                                   ->get();
    }
    */
    public function deleteInvoiceItem(Request $request)
    {
        $item = Item::find($request->id);
        //check if sum_total is greater than 0 
        //and sub the val of the deletd item
        if ($item->invoice->sum_total > 0) {
            $item->invoice->sum_total = $item->invoice->sum_total - $item->total;
            $item->invoice->save();
        }

        return  $item->delete() ? true:false;
    }
}
