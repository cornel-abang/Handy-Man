<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItemsController;
use App\User;
use App\Service;
use App\Invoice;
use App\Item;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy('created_at','desc')->paginate(5);
        $title = 'All Invoices';
        return view('invoice.all', compact('title', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Invoice';
        return view('invoice.new', compact('title'));
    }

    public function getAccount(Request $request)
    {
        $acct_id = $request->acct_id;

        $acct = User::select('id','name')->where('account_id', $acct_id)->get();
        //dd();
        if (!empty($acct[0]->id)) {
            $acct_detail = '<div class="" style="color: green;"><span class="fa fa-user"> '.$acct[0]->name.'</span></div>';
            $id = $acct[0]->id;
            return ['success'=>1, 'acct'=>$acct_detail, 'id'=>$id, 'name'=>$acct[0]->name]; 
        }else{
            $notFound ='<div class="" style="color: red;"><span class="fa fa-times-circle"> </span> No account matched</div>';
            return['acct'=> $notFound];
        }
    }

    public function getServices(Request $request)
    {
        $user_id = $request->user_id;

        $services = Service::select('id','category')->where('user_id', $user_id)->get();

        return ['success'=>1, 'acct'=>$services->toArray()];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'job' => 'required',
            'item_name' =>  'required',
            'item_price' =>  'required',
            'item_qty' =>  'required'
        ];

        $this->validate($request, $rules);

        $invoice = Invoice::create(['service_id' => $request->job]);
        $sum_total = 0;
        if (!empty($request->item_name)) {
            //get back the total to store in invoice table
            $totals = ItemsController::storeItems($request->all(), $invoice->id);
            //loop through totals and get the sum_total
            foreach ($totals as $total) {
                $sum_total += array_sum($total);
            } 
        }

        //add total amount for the invoice
        $invoice->sum_total = $sum_total;
        $res = $invoice->save();
        
        if ($res) {

            return redirect(route('all-invoices'))->with('success', 'Invoice successfully created');
        }
        return redirect(route('new-invoice'))->with('error', 'Unable to create invoice');
    }
       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $title = 'Edit invoice';
        return view('invoice.edit', compact('invoice', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoice_id)
    {
        $rules = [
            'item_name' =>  'required',
            'item_price' =>  'required',
            'item_qty' =>  'required'
        ];

        $this->validate($request, $rules);
        //get back the total to store in invoice table
        $totals = ItemsController::storeItemsUpdate($request->all(), $invoice_id);
        $sum_total = 0;
        //loop through totals and get the sum_total
        foreach ($totals as $total) {
            $sum_total += array_sum($total);
        }

        $invoice = Invoice::find($invoice_id);
        //add total amount for the invoice
        $invoice->sum_total = $sum_total;
        $res = $invoice->save();
        
        if ($res) {

            return redirect(route('all-invoices'))->with('success', 'Invoice successfully updated');
        }
        return redirect(route('new-invoice'))->with('error', 'Unable to update invoice');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAjax(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);
        if ($invoice->delete()) {
            session()->flash('success','Invoice deleted!');
        }else{
            session()->flash('error','Unable to delete invoice');
        }
        return route('all-invoices');
    }

    public function destroyAjaxFromAll(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);
        if ($invoice->delete()) {
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }
}
